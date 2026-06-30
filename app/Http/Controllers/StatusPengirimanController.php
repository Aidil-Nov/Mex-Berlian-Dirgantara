<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kargo;
use App\Models\HistoryStatus;
use App\Models\MasterPenerbangan;
use App\Models\MasterKota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache; // Wajib di-import untuk manajemen memori cache dropdown

class StatusPengirimanController extends Controller
{
    public function index()
    {
        $kargo = Kargo::with([
            'pengirim',
            'kotaAsal',
            'kotaTujuan',
            'history' => function ($q) {
                $q->latest('waktu_update');
            }
        ])->latest()->get();

        $diproses = $kargo->whereNotIn('status_terakhir', ['Offload', 'Selesai', 'Di Terima']);
        $tertunda = $kargo->where('status_terakhir', 'Offload');
        $selesai = $kargo->whereIn('status_terakhir', ['Selesai', 'Di Terima']);

        $penerbanganAktif = [];
        $cacheKey = 'flights_dropdown_scheduled_pnk';

        // STRATEGI CACHING: Cek apakah data list jadwal pesawat bandara asal sudah ada di cache
        if (Cache::has($cacheKey)) {
            $penerbanganAktif = Cache::get($cacheKey);
        } else {
            // JIKA KOSONG: Baru panggil API Aviationstack (Maksimal 1 kali request per 2 jam)
            $apiKey = env('AVIATION_API_KEY', 'd595ef7c4649c7577520bd16203542ce');

            // Mapping Kode IATA Otomatis dari Database Master Kota
            $semuaKota = MasterKota::all();
            $iataMap = [];
            foreach ($semuaKota as $kota) {
                if (preg_match('/\((.*?)\)/', $kota->nama_kota, $match)) {
                    $iataMap[strtoupper($match[1])] = $kota->id;
                }
            }

            try {
                $response = Http::timeout(5)->get("http://api.aviationstack.com/v1/flights", [
                    'access_key' => $apiKey,
                    'dep_iata' => 'PNK', // Bandara Keberangkatan Utama: Supadio Pontianak
                    'flight_status' => 'scheduled'
                ]);

                if ($response->successful()) {
                    $apiData = $response->json()['data'] ?? [];
                    $tempFlights = [];

                    foreach ($apiData as $flight) {
                        $arrIata = strtoupper($flight['arrival']['iata'] ?? '');
                        $idTujuan = $iataMap[$arrIata] ?? null;

                        if ($idTujuan && $flight['flight']['iata'] && $flight['airline']['name']) {
                            $tempFlights[] = [
                                'id_kota_asal' => $iataMap['PNK'] ?? 1,
                                'id_kota_tujuan' => $idTujuan,
                                'no_penerbangan' => $flight['flight']['iata'],
                                'maskapai' => $flight['airline']['name']
                            ];
                        }
                    }

                    // Hanya simpan ke cache jika data dari API berhasil didapatkan (tidak kosong)
                    if (!empty($tempFlights)) {
                        $penerbanganAktif = collect($tempFlights)->unique('no_penerbangan')->values()->all();

                        // Kunci data di cache selama 2 Jam (120 Menit)
                        Cache::put($cacheKey, $penerbanganAktif, now()->addHours(2));
                    }
                }
            } catch (\Exception $e) {
                // Abaikan error jaringan API agar proses tetap berjalan lancar ke tahap fallback
            }
        }

        // ====================================================================
        // LOGIKA FALLBACK LAYER: JIKA API LIMIT/OFFLINE, AMBIL DARI LOCAL DB
        // ====================================================================
        if (empty($penerbanganAktif)) {
            $pesawatLokal = MasterPenerbangan::whereIn('status_penerbangan', ['Scheduled', 'Active'])->get();
            $tempLokal = [];

            foreach ($pesawatLokal as $pesawat) {
                $tempLokal[] = [
                    'id_kota_asal' => $pesawat->id_kota_asal,
                    'id_kota_tujuan' => $pesawat->id_kota_tujuan,
                    'no_penerbangan' => $pesawat->no_penerbangan,
                    'maskapai' => $pesawat->maskapai
                ];
            }
            $penerbanganAktif = collect($tempLokal)->unique('no_penerbangan')->values();
        } else {
            // Konversi kembali menjadi Collection agar kompatibel dengan perulangan Blade view Anda
            $penerbanganAktif = collect($penerbanganAktif);
        }

        return view('admin.kelola-status-pengiriman', compact('diproses', 'tertunda', 'selesai', 'penerbanganAktif'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'no_resi' => 'required|exists:kargo,no_resi',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
            'data_penerbangan' => 'required_if:status,Loading|string|nullable',
        ]);

        DB::beginTransaction();

        try {
            $kargo = Kargo::where('no_resi', $request->no_resi)->first();
            $updateData = ['status_terakhir' => $request->status];
            $keteranganLog = $request->keterangan;

            // Logika jika status LOADING
            if ($request->status === 'Loading') {
                $pecahData = explode('||', $request->data_penerbangan);

                $updateData['no_penerbangan'] = $pecahData[0] ?? null;
                $updateData['maskapai'] = $pecahData[1] ?? 'Mitra Maskapai';

                if (empty($keteranganLog)) {
                    $keteranganLog = "Kargo berhasil dipasangkan ke armada {$updateData['no_penerbangan']} ({$updateData['maskapai']}) and sedang dalam proses loading ke pesawat.";
                }
            }
            // Logika jika status selain LOADING
            else {
                if (in_array(strtolower($request->status), ['entry', 'x-ray', 'offload'])) {
                    $updateData['no_penerbangan'] = null;
                    $updateData['maskapai'] = null;
                }

                if (empty($keteranganLog)) {
                    $keteranganLog = match (strtolower($request->status)) {
                        'entry' => 'Paket telah diterima, diukur, dan didaftarkan ke dalam sistem fasilitas asal.',
                        'x-ray' => 'Paket sedang melewati proses inspeksi dan pemeriksaan keamanan X-Ray bandara.',
                        'offload' => 'Kargo mengalami penundaan keberangkatan (Offload) dan sedang ditangani oleh petugas.',
                        'selesai', 'di terima' => 'Kargo telah berhasil diserahkan dan diambil oleh pihak penerima.',
                        default => 'Status pengiriman telah diperbarui menjadi ' . $request->status . '.'
                    };
                }
            }

            Kargo::where('no_resi', $request->no_resi)->update($updateData);

            HistoryStatus::create([
                'no_resi' => $request->no_resi,
                'id_user' => Auth::id(),
                'status' => $request->status,
                'keterangan' => $keteranganLog,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Status kargo berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
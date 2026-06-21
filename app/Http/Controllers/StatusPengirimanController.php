<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kargo;
use App\Models\HistoryStatus;
use App\Models\MasterPenerbangan; // Masukkan Model Baru di Sini
use App\Models\MasterKota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

        // FULL API: AMBIL JADWAL PENERBANGAN REAL-TIME DARI RADAR
        $apiKey = 'd595ef7c4649c7577520bd16203542ce';
        $penerbanganAktif = [];

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
                'dep_iata' => 'PNK', // Bandara Asal Selalu Pontianak
                'flight_status' => 'scheduled'
            ]);

            if ($response->successful()) {
                $apiData = $response->json()['data'] ?? [];

                foreach ($apiData as $flight) {
                    $arrIata = strtoupper($flight['arrival']['iata'] ?? '');
                    $idTujuan = $iataMap[$arrIata] ?? null;

                    if ($idTujuan && $flight['flight']['iata'] && $flight['airline']['name']) {
                        $penerbanganAktif[] = [
                            'id_kota_asal' => $iataMap['PNK'] ?? 1,
                            'id_kota_tujuan' => $idTujuan,
                            'no_penerbangan' => $flight['flight']['iata'],
                            'maskapai' => $flight['airline']['name']
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            // Abaikan error jaringan API agar proses di bawah tetap berjalan
        }

        // ====================================================================
        // LOGIKA FALLBACK: JIKA API MATI / LIMIT HABIS, AMBIL DATA LOCAL DB
        // ====================================================================
        if (empty($penerbanganAktif)) {
            // Ambil data pesawat dummy dari database lokal master_penerbangan
            $pesawatLokal = MasterPenerbangan::whereIn('status_penerbangan', ['Scheduled', 'Active'])->get();

            foreach ($pesawatLokal as $pesawat) {
                $penerbanganAktif[] = [
                    'id_kota_asal' => $pesawat->id_kota_asal,
                    'id_kota_tujuan' => $pesawat->id_kota_tujuan,
                    'no_penerbangan' => $pesawat->no_penerbangan,
                    'maskapai' => $pesawat->maskapai
                ];
            }
        }

        // Hapus duplikat nomor penerbangan jika ada
        $penerbanganAktif = collect($penerbanganAktif)->unique('no_penerbangan')->values();

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
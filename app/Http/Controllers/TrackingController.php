<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kargo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache; // Wajib di-import untuk mengaktifkan fitur Cache
use Carbon\Carbon;

class TrackingController extends Controller
{
    // =====================================================================
    // METHOD 1: UNTUK INTERNAL ADMIN (Tetap Menggunakan Fungsi Helper)
    // =====================================================================
    public function index(Request $request)
    {
        $kargo = null;
        $detailPesawat = null;

        if ($request->has('resi')) {
            $resi = $request->input('resi');

            $kargo = Kargo::with([
                'pengirim',
                'penerima',
                'kotaAsal',
                'kotaTujuan',
                'history' => function ($query) {
                    $query->orderBy('waktu_update', 'asc');
                }
            ])->where('no_resi', $resi)->first();

            // Panggil Helper Method API (Sudah terlindungi Cache)
            if ($kargo) {
                $detailPesawat = $this->getFlightDetails($kargo->no_penerbangan, $kargo->maskapai);
            }
        }

        return view('admin.tracking-pengiriman', compact('kargo', 'detailPesawat'));
    }

    // =====================================================================
    // METHOD 2: UNTUK PUBLIC CUSTOMER / GUEST (DENGAN VERIFIKASI KEAMANAN)
    // =====================================================================
    public function publicTracking(Request $request)
    {
        // 1. Proteksi Type-Casting (Cegah Array Injection pada URL)
        $no_resi = strtoupper((string) $request->query('no_resi'));
        $digit = (string) $request->query('digit');

        if (empty($no_resi)) {
            return redirect()->route('home');
        }

        // 2. Validasi Ketat 4 Digit Angka (Hanya boleh berisi nomor)
        if (empty($digit) || strlen($digit) !== 4 || !ctype_digit($digit)) {
            return redirect()->route('home')->with('error', 'Verifikasi Gagal! Masukkan format 4 digit angka yang valid.');
        }

        // 3. Ambil data kargo beserta relasi
        $kargo = Kargo::with([
            'kotaAsal',
            'kotaTujuan',
            'pengirim',
            'penerima',
            'history' => function ($query) {
                $query->orderBy('waktu_update', 'desc'); // Urutkan dari yang terbaru
            }
        ])->where('no_resi', $no_resi)->first();

        if (!$kargo) {
            return redirect()->route('home')->with('error', 'Nomor resi tidak ditemukan. Silakan periksa kembali kode resi Anda.');
        }

        // 4. Sanitasi Ekstra & Pencocokan Nomor HP
        $hpPengirim = preg_replace('/[^0-9]/', '', (string) ($kargo->pengirim->no_hp ?? ''));
        $hpPenerima = preg_replace('/[^0-9]/', '', (string) ($kargo->penerima->no_hp ?? ''));

        $last4Pengirim = substr($hpPengirim, -4);
        $last4Penerima = substr($hpPenerima, -4);

        if ($digit !== $last4Pengirim && $digit !== $last4Penerima) {
            return redirect()->route('home')->with('error', 'Verifikasi Gagal! 4 angka terakhir nomor telepon salah atau tidak sesuai dengan manifes kargo.');
        }

        // 5. Jika Lolos Validasi -> Panggil Helper Method API (Sudah terlindungi Cache)
        $detailPesawat = $this->getFlightDetails($kargo->no_penerbangan, $kargo->maskapai);

        return view('customer.partials.tracking-result', compact('kargo', 'detailPesawat', 'no_resi'));
    }

    // =====================================================================
    // METHOD 3: HELPER FUNCTION DENGAN IMPLEMENTASI CACHE LAYER (ARRAY SAFE)
    // =====================================================================
    private function getFlightDetails($no_penerbangan, $maskapai_default)
    {
        if (empty($no_penerbangan)) {
            return null;
        }

        $cacheKey = 'flight_radar_' . strtoupper(str_replace(' ', '', $no_penerbangan));

        // JIKA ADA DI CACHE: Ambil data array, lalu cast menjadi (object) secara on-the-fly
        if (Cache::has($cacheKey)) {
            $cachedData = Cache::get($cacheKey);
            return is_array($cachedData) ? (object) $cachedData : null;
        }

        try {
            $apiKey = env('AVIATION_API_KEY', 'd595ef7c4649c7577520bd16203542ce');

            $response = Http::timeout(5)->get("http://api.aviationstack.com/v1/flights", [
                'access_key' => $apiKey,
                'flight_iata' => $no_penerbangan
            ]);

            if ($response->successful() && !empty($response->json()['data'])) {
                $apiData = $response->json()['data'][0];
                $waktuMentah = $apiData['arrival']['estimated'] ?? $apiData['arrival']['scheduled'] ?? null;

                $etaFormatted = 'Menunggu update radar';
                if ($waktuMentah) {
                    $etaFormatted = Carbon::parse($waktuMentah)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB';
                }

                // PERBAIKAN: Definisikan sebagai ARRAY MURNI (bukan object) agar aman di-serialize oleh cache driver
                $flightInfoArray = [
                    'maskapai' => $apiData['airline']['name'] ?? $maskapai_default,
                    'jenis_pesawat' => $apiData['aircraft']['production_line'] ?? 'Informasi Tidak Tersedia',
                    'status_penerbangan' => ucfirst($apiData['flight_status'] ?? 'Scheduled'),
                    'eta' => $etaFormatted,
                    'sumber' => 'Live Radar API (Cached)'
                ];

                // Simpan struktur Array murni ke dalam cache selama 30 menit
                Cache::put($cacheKey, $flightInfoArray, now()->addMinutes(30));

                // Kembalikan dalam bentuk object agar tidak merusak kode file Blade views Anda
                return (object) $flightInfoArray;
            }
        } catch (\Exception $e) {
            // Abaikan secara diam-diam jika jaringan bermasalah/API Timeout
        }

        return null;
    }
}
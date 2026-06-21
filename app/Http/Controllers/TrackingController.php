<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kargo;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TrackingController extends Controller
{
    // METHOD UNTUK INTERNAL ADMIN (SUDAH ADA)
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

            if ($kargo && $kargo->no_penerbangan) {
                try {
                    $apiKey = 'd595ef7c4649c7577520bd16203542ce';
                    $response = Http::timeout(5)->get("http://api.aviationstack.com/v1/flights", [
                        'access_key' => $apiKey,
                        'flight_iata' => $kargo->no_penerbangan
                    ]);

                    if ($response->successful() && !empty($response->json()['data'])) {
                        $apiData = $response->json()['data'][0];
                        $waktuMentah = $apiData['arrival']['estimated'] ?? $apiData['arrival']['scheduled'] ?? null;

                        $etaFormatted = 'Menunggu update radar';
                        if ($waktuMentah) {
                            $etaFormatted = Carbon::parse($waktuMentah)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB';
                        }

                        $detailPesawat = (object) [
                            'maskapai' => $apiData['airline']['name'] ?? $kargo->maskapai,
                            'jenis_pesawat' => $apiData['aircraft']['production_line'] ?? 'Informasi Tidak Tersedia',
                            'status_penerbangan' => ucfirst($apiData['flight_status'] ?? 'Scheduled'),
                            'eta' => $etaFormatted,
                            'sumber' => 'Live Radar API'
                        ];
                    }
                } catch (\Exception $e) {
                    // Silently ignore network error
                }
            }
        }

        return view('admin.tracking-pengiriman', compact('kargo', 'detailPesawat'));
    }

    // =====================================================================
    // METHOD BARU: UNTUK PUBLIC CUSTOMER / GUEST (TAMBAHKAN KODE DI BAWAH INI)
    // =====================================================================
    // =====================================================================
    // METHOD: UNTUK PUBLIC CUSTOMER / GUEST (DENGAN VERIFIKASI KEAMANAN)
    // =====================================================================
    // =====================================================================
    // METHOD: UNTUK PUBLIC CUSTOMER / GUEST (DENGAN VERIFIKASI KEAMANAN)
    // =====================================================================
    public function publicTracking(Request $request)
    {
        $no_resi = strtoupper($request->query('no_resi'));
        $digit = $request->query('digit'); // Menangkap 4 angka terakhir dari pop-up

        if (!$no_resi) {
            return redirect()->route('home');
        }

        // Validasi jika 4 digit verifikasi kosong
        if (!$digit || strlen($digit) !== 4) {
            return redirect()->route('home')->with('error', 'Verifikasi Gagal! 4 digit nomor telepon wajib diisi.');
        }

        // Ambil data kargo beserta pengirim & penerima untuk verifikasi nomor HP
        $kargo = Kargo::with([
            'kotaAsal',
            'kotaTujuan',
            'pengirim', // Muat data pengirim
            'penerima', // Muat data penerima
            'history' => function ($query) {
                $query->orderBy('waktu_update', 'desc');
            }
        ])->where('no_resi', $no_resi)->first();

        // Jika resi tidak ditemukan
        if (!$kargo) {
            return redirect()->route('home')->with('error', 'Nomor resi tidak ditemukan. Silakan periksa kembali kode resi Anda.');
        }

        // BERSIHKAN & AMBIL 4 ANGKA TERAKHIR NO HP (Pencegahan jika di DB ada spasi/strip)
        $hpPengirim = preg_replace('/[^0-9]/', '', $kargo->pengirim->no_hp ?? '');
        $hpPenerima = preg_replace('/[^0-9]/', '', $kargo->penerima->no_hp ?? '');

        $last4Pengirim = substr($hpPengirim, -4);
        $last4Penerima = substr($hpPenerima, -4);

        // COCOKKAN: Harus sama dengan salah satu (Pengirim atau Penerima)
        if ($digit !== $last4Pengirim && $digit !== $last4Penerima) {
            return redirect()->route('home')->with('error', 'Verifikasi Gagal! 4 angka terakhir nomor telepon salah atau tidak sesuai.');
        }

        // JIKA LOLOS VERIFIKASI -> Ambil Live Radar API (Jika ada nomor penerbangan)
        $detailPesawat = null;
        if ($kargo->no_penerbangan) {
            try {
                $apiKey = 'd595ef7c4649c7577520bd16203542ce';
                $response = Http::timeout(5)->get("http://api.aviationstack.com/v1/flights", [
                    'access_key' => $apiKey,
                    'flight_iata' => $kargo->no_penerbangan
                ]);

                if ($response->successful() && !empty($response->json()['data'])) {
                    $apiData = $response->json()['data'][0];
                    $waktuMentah = $apiData['arrival']['estimated'] ?? $apiData['arrival']['scheduled'] ?? null;

                    $etaFormatted = 'Menunggu update radar';
                    if ($waktuMentah) {
                        $etaFormatted = Carbon::parse($waktuMentah)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB';
                    }

                    $detailPesawat = (object) [
                        'maskapai' => $apiData['airline']['name'] ?? $kargo->maskapai,
                        'status_penerbangan' => ucfirst($apiData['flight_status'] ?? 'Scheduled'),
                        'eta' => $etaFormatted
                    ];
                }
            } catch (\Exception $e) {
                // Tetap aman jika API timeout
            }
        }

        return view('customer.partials.tracking-result', compact('kargo', 'detailPesawat', 'no_resi'));
    }
}
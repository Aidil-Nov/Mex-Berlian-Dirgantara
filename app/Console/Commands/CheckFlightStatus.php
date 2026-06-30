<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kargo;
use App\Models\HistoryStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckFlightStatus extends Command
{
    protected $signature = 'app:check-flight-status';
    protected $description = 'Mengecek status API penerbangan berdasarkan nomor pesawat unik dan mengupdate status kargo secara efisien';

    public function handle()
    {
        // 1. Ambil semua kargo aktif yang memiliki nomor penerbangan, lalu kelompokkan berdasarkan nomor penerbangan
        // Menggunakan groupBy membantu kita menghindari pemanggilan API berulang untuk pesawat yang sama
        $kargoGrouped = Kargo::whereIn('status_terakhir', ['Loading', 'On Flight', 'Offload'])
            ->whereNotNull('no_penerbangan')
            ->get()
            ->groupBy('no_penerbangan');

        if ($kargoGrouped->isEmpty()) {
            $this->info('Tidak ada kargo aktif yang perlu dipantau radar saat ini.');
            return;
        }

        $apiKey = env('AVIATION_API_KEY', '8ad7060a729baa7d9490f20b613b5d42');
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        // Looping dilakukan per NOMOR PENERBANGAN (Pesawat), BUKAN per kargo (Sangat Hemat Token!)
        foreach ($kargoGrouped as $noPenerbangan => $daftarKargo) {

            $this->info("Menghubungi Radar API untuk mengecek nomor penerbangan: {$noPenerbangan}...");

            try {
                // 2. Tembak API hanya 1 kali untuk nomor penerbangan ini
                $response = Http::timeout(5)->get("http://api.aviationstack.com/v1/flights", [
                    'access_key' => $apiKey,
                    'flight_iata' => $noPenerbangan
                ]);

                if ($response->successful() && isset($response->json()['data'])) {
                    $apiData = $response->json()['data'];

                    // FILTER: Cari jadwal penerbangan spesifik hari ini
                    $flightToday = collect($apiData)->first(function ($flight) use ($tanggalHariIni) {
                        return ($flight['flight_date'] ?? '') === $tanggalHariIni;
                    });

                    if ($flightToday) {
                        $apiStatus = strtolower($flightToday['flight_status']);

                        // 3. Looping semua kargo yang menumpang di pesawat ini untuk disesuaikan statusnya
                        foreach ($daftarKargo as $kargo) {
                            $statusBaru = null;
                            $keteranganLog = '';

                            // KONDISI A: Pesawat CANCELLED -> Otomatis MASUK ke Offload
                            if ($apiStatus === 'cancelled' && in_array($kargo->status_terakhir, ['Loading', 'On Flight'])) {
                                $statusBaru = 'Offload';
                                $keteranganLog = "Sistem Otomatis: Penerbangan {$noPenerbangan} dibatalkan oleh maskapai. Kargo otomatis di-offload untuk antre armada baru.";
                            }

                            // KONDISI B: Pesawat SCHEDULED saat kargo sedang Offload -> Otomatis KEMBALI ke Loading
                            if ($apiStatus === 'scheduled' && $kargo->status_terakhir === 'Offload') {
                                $statusBaru = 'Loading';
                                $keteranganLog = "Otomatisasi Sistem: Jadwal penerbangan {$noPenerbangan} telah pulih/dijadwalkan kembali oleh maskapai. Kargo kembali ke tahap Loading.";
                            }

                            // KONDISI C: Pesawat Lepas Landas (ACTIVE) -> Otomatis ke On Flight
                            if ($apiStatus === 'active' && in_array($kargo->status_terakhir, ['Loading', 'Offload'])) {
                                $statusBaru = 'On Flight';
                                $keteranganLog = "Otomatisasi Sistem: Pesawat {$noPenerbangan} telah lepas landas menuju kota tujuan (Live Radar).";
                            }

                            // KONDISI D: Pesawat Mendarat (LANDED) -> Otomatis ke Landing
                            if ($apiStatus === 'landed' && $kargo->status_terakhir === 'On Flight') {
                                $statusBaru = 'Landing';
                                $keteranganLog = "Otomatisasi Sistem: Pesawat {$noPenerbangan} telah mendarat dengan selamat di bandara tujuan. Kargo siap dibongkar muat.";
                            }

                            // 4. Jika ada perubahan status dari radar, eksekusi ke database kargo tersebut
                            if ($statusBaru) {
                                DB::beginTransaction();
                                try {
                                    $kargo->update(['status_terakhir' => $statusBaru]);

                                    // Catat riwayat log timeline sistem
                                    HistoryStatus::create([
                                        'no_resi' => $kargo->no_resi,
                                        'id_user' => null, // null menandakan aksi otomatis robot sistem
                                        'status' => $statusBaru,
                                        'keterangan' => $keteranganLog,
                                        'waktu_update' => now(),
                                    ]);

                                    DB::commit();
                                    $this->info("-> Kargo {$kargo->no_resi} berhasil diperbarui menjadi {$statusBaru}.");
                                } catch (\Exception $e) {
                                    DB::rollBack();
                                    Log::error("Gagal update status otomatis kargo {$kargo->no_resi}: " . $e->getMessage());
                                }
                            }
                        }
                    } else {
                        $this->line("Jadwal penerbangan untuk armada {$noPenerbangan} hari ini belum dirilis di radar.");
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Gagal koneksi API Aviationstack untuk penerbangan {$noPenerbangan}: " . $e->getMessage());
            }
        }
    }
}
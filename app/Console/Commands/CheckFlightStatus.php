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
    protected $description = 'Mengecek status API penerbangan hari ini dan mengupdate status kargo secara otomatis';

    public function handle()
    {
        // 1. Ambil kargo berstatus Loading, On Flight, ATAU Offload yang memiliki nomor penerbangan
        $kargoAktif = Kargo::whereIn('status_terakhir', ['Loading', 'On Flight', 'Offload'])
            ->whereNotNull('no_penerbangan')
            ->get();

        if ($kargoAktif->isEmpty()) {
            $this->info('Tidak ada kargo yang perlu dipantau saat ini.');
            return;
        }

        $apiKey = 'd595ef7c4649c7577520bd16203542ce';
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        foreach ($kargoAktif as $kargo) {
            $statusBaru = null;
            $keteranganLog = '';

            try {
                // 2. Tembak API berdasarkan nomor penerbangan kargo
                $response = Http::timeout(5)->get("http://api.aviationstack.com/v1/flights", [
                    'access_key' => $apiKey,
                    'flight_iata' => $kargo->no_penerbangan
                ]);

                if ($response->successful() && isset($response->json()['data'])) {
                    $apiData = $response->json()['data'];

                    // FILTER: Cari data penerbangan yang spesifik untuk HARI INI
                    $flightToday = collect($apiData)->first(function ($flight) use ($tanggalHariIni) {
                        return ($flight['flight_date'] ?? '') === $tanggalHariIni;
                    });

                    if ($flightToday) {
                        $apiStatus = strtolower($flightToday['flight_status']);

                        // ====================================================================
                        // LOGIKA TRANSISI STATUS OTOMATIS (STATE MACHINE RADAR)
                        // ====================================================================

                        // KONDISI A: Pesawat CANCELLED -> Otomatis MASUK ke Offload
                        if ($apiStatus === 'cancelled' && in_array($kargo->status_terakhir, ['Loading', 'On Flight'])) {
                            $statusBaru = 'Offload';
                            $keteranganLog = "Sistem Otomatis: Penerbangan {$kargo->no_penerbangan} dibatalkan oleh maskapai. Kargo otomatis di-offload untuk antre armada baru.";
                        }

                        // KONDISI B: Pesawat dijadwalkan ulang/pulih (SCHEDULED) saat kargo sedang Offload -> Otomatis KEMBALI ke Loading
                        unset($statusBaru); // Reset variabel pengaman
                        if ($apiStatus === 'scheduled' && $kargo->status_terakhir === 'Offload') {
                            $statusBaru = 'Loading';
                            $keteranganLog = "Otomatisasi Sistem: Jadwal penerbangan {$kargo->no_penerbangan} telah pulih/dijadwalkan kembali oleh maskapai. Kargo kembali ke tahap Loading.";
                        }

                        // KONDISI C: Pesawat Lepas Landas (ACTIVE) -> Otomatis ke On Flight
                        if ($apiStatus === 'active' && in_array($kargo->status_terakhir, ['Loading', 'Offload'])) {
                            $statusBaru = 'On Flight';
                            $keteranganLog = "Otomatisasi Sistem: Pesawat {$kargo->no_penerbangan} telah lepas landas menuju kota tujuan (Live Radar).";
                        }

                        // KONDISI D: Pesawat Mendarat (LANDED) -> Otomatis ke Landing
                        if ($apiStatus === 'landed' && $kargo->status_terakhir === 'On Flight') {
                            $statusBaru = 'Landing';
                            $keteranganLog = "Otomatisasi Sistem: Pesawat {$kargo->no_penerbangan} telah mendarat dengan selamat di bandara tujuan. Kargo siap dibongkar muat.";
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Gagal koneksi API untuk kargo {$kargo->no_resi}: " . $e->getMessage());
            }

            // 3. Eksekusi Perubahan Status ke Database jika Kondisi Terpenuhi
            if (isset($statusBaru) && $statusBaru) {
                DB::beginTransaction();
                try {
                    // SEKARANG: Nomor penerbangan TIDAK DIHAPUS saat Offload agar tetap bisa dipantau robot
                    $kargo->update(['status_terakhir' => $statusBaru]);

                    // Catat riwayat log timeline sistem
                    HistoryStatus::create([
                        'no_resi' => $kargo->no_resi,
                        'id_user' => null, // Menandakan aksi otomatis dilakukan oleh "Sistem"
                        'status' => $statusBaru,
                        'keterangan' => $keteranganLog,
                        'waktu_update' => now(),
                    ]);

                    DB::commit();
                    $this->info("Kargo {$kargo->no_resi} otomatis berubah menjadi {$statusBaru} berdasarkan Live API hari ini.");
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error("Gagal update status otomatis {$kargo->no_resi}: " . $e->getMessage());
                }
            }
        }
    }
}
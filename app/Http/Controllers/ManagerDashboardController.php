<?php

namespace App\Http\Controllers;

use App\Models\Kargo;
use App\Models\Komplain;
use App\Models\HistoryStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ManagerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $hariIni = Carbon::today();
        $kemarin = Carbon::yesterday();

        // 1. VOLUME KARGO
        $volumeHariIni = Kargo::whereDate('created_at', $hariIni)->sum('berat');
        $volumeKemarin = Kargo::whereDate('created_at', $kemarin)->sum('berat');

        $trendVolume = 0;
        if ($volumeKemarin > 0) {
            $trendVolume = (($volumeHariIni - $volumeKemarin) / $volumeKemarin) * 100;
        } elseif ($volumeHariIni > 0) {
            $trendVolume = 100; 
        }

        // =====================================================================
        // 2. QUERY GRAFIK BERDASARKAN FILTER (HARIAN / BULANAN / TAHUNAN)
        // =====================================================================
        $filter = $request->query('filter', 'harian'); // Tangkap filter dari URL, default: harian
        $grafikVolume = [];
        $maxVolume = 0;

        if ($filter === 'bulanan') {
            // Tampilkan 6 Bulan Terakhir
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::today()->startOfMonth()->subMonths($i);
                $sumBerat = Kargo::whereYear('created_at', $date->year)
                                 ->whereMonth('created_at', $date->month)
                                 ->sum('berat');
                
                if ($sumBerat > $maxVolume) $maxVolume = $sumBerat;
                
                $grafikVolume[] = [
                    'label'  => $date->translatedFormat('F Y'), // Contoh: Januari 2026
                    'hari'   => $date->translatedFormat('M'),   // Contoh: Jan
                    'volume' => $sumBerat
                ];
            }
        } elseif ($filter === 'tahunan') {
            // Tampilkan 5 Tahun Terakhir
            for ($i = 4; $i >= 0; $i--) {
                $date = Carbon::today()->startOfYear()->subYears($i);
                $sumBerat = Kargo::whereYear('created_at', $date->year)->sum('berat');
                
                if ($sumBerat > $maxVolume) $maxVolume = $sumBerat;
                
                $grafikVolume[] = [
                    'label'  => $date->format('Y'), // Contoh: 2026
                    'hari'   => $date->format('Y'), // Contoh: 2026
                    'volume' => $sumBerat
                ];
            }
        } else {
            // Default: Harian (7 Hari Terakhir)
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $sumBerat = Kargo::whereDate('created_at', $date)->sum('berat');
                
                if ($sumBerat > $maxVolume) $maxVolume = $sumBerat;
                
                $grafikVolume[] = [
                    'label'  => $date->translatedFormat('d M Y'), // Contoh: 30 Jun 2026
                    'hari'   => $date->translatedFormat('D'),     // Contoh: Sen, Sel
                    'volume' => $sumBerat
                ];
            }
        }

        $maxVolume = $maxVolume > 0 ? $maxVolume : 1;

        // 3. METRIK EKSISTING
        $totalOffload = Kargo::where('status_terakhir', 'Offload')->count();
        $totalKomplainMenunggu = Komplain::where('status', 'menunggu')->count();
        
        $logTerbaru = HistoryStatus::with('kargo')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 4. LEMPAR KE VIEW
        return view('manager.dashboard', compact(
            'totalOffload', 
            'totalKomplainMenunggu', 
            'logTerbaru',
            'volumeHariIni',
            'trendVolume',
            'grafikVolume', // Nama variabel diganti jadi lebih umum
            'maxVolume',
            'filter' // Lempar string filter aktif ke view
        ));
    }
}
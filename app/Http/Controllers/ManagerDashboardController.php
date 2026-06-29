<?php

namespace App\Http\Controllers;

use App\Models\Kargo;
use App\Models\Komplain;
use App\Models\HistoryStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung total kargo yang berstatus 'Offload' (Tertunda)
        $totalOffload = Kargo::where('status_terakhir', 'Offload')->count();

        // 2. Hitung total komplain masuk yang berstatus 'menunggu'
        $totalKomplainMenunggu = Komplain::where('status', 'menunggu')->count();

        // 3. Ambil 5 data log pergerakan kargo terbaru dari tabel history_status beserta relasi kargonya
        $logTerbaru = HistoryStatus::with('kargo')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Kirim semua data ke halaman view dashboard manajer dengan aman
        return view('manager.dashboard', compact('totalOffload', 'totalKomplainMenunggu', 'logTerbaru'));
    }
}

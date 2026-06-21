<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kargo;
use App\Models\HistoryStatus;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Kargo Masuk (Entry) Hari Ini
        $kargoHariIni = Kargo::whereDate('created_at', Carbon::today())->count();

        // 2. Kargo Loading (Menggantikan On Flight karena sudah dihapus)
        $kargoLoading = Kargo::where('status_terakhir', 'Loading')->count();

        // 3. Kargo Offload (Membutuhkan Perhatian)
        $kargoOffload = Kargo::where('status_terakhir', 'Offload')->count();

        // 4. Kargo Tiba Hari Ini (Di Terima / Selesai)
        $kargoTiba = HistoryStatus::whereIn('status', ['Selesai', 'Di Terima'])
            ->whereDate('waktu_update', Carbon::today())
            ->count();

        // 5. Riwayat 5 Update Status Terakhir (Dari tabel history_status)
        $recentUpdates = HistoryStatus::with(['kargo.kotaAsal', 'kargo.kotaTujuan', 'user'])
            ->latest('waktu_update')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'kargoHariIni',
            'kargoLoading',
            'kargoOffload',
            'kargoTiba',
            'recentUpdates'
        ));
    }
}
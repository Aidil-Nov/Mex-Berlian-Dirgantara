<?php

namespace App\Http\Controllers;

use App\Models\Kargo;
use App\Models\Komplain;
use App\Models\HistoryStatus;
use Illuminate\Http\Request;

class ManagerMonitoringController extends Controller
{
    public function index()
    {
        // 1. Ambil Total Kargo yang sedang Offload (Kritis)
        $kargoOffloadCount = Kargo::where('status_terakhir', 'Offload')->count();

        // 2. Ambil Total Keluhan yang baru masuk (Menunggu Validasi)
        $keluhanMasukCount = Komplain::where('status', 'menunggu')->count();

        // 3. Ambil Daftar Kargo Kritis (Status Offload atau anomali lainnya)
        // Kita beserta relasinya (Eager Loading) agar tidak kena N+1 Query Issue
        $kargoKritis = Kargo::with([
            'pengirim',
            'kotaAsal',
            'kotaTujuan',
            'history' => function ($query) {
                // Ambil history terbaru untuk melihat keterangan error-nya
                $query->orderBy('created_at', 'desc');
            }
        ])
            ->whereIn('status_terakhir', ['Offload']) // Bisa ditambah 'Pending Karantina' jika status itu ada di sistem Anda
            ->orderBy('updated_at', 'desc')
            ->get();

        // 4. Ambil Log Aktivitas Admin (Audit Trail)
        $auditTrail = HistoryStatus::with('user', 'kargo')
            ->orderBy('created_at', 'desc')
            ->take(10) // Ambil 10 aktivitas terakhir
            ->get();

        // 5. Lempar semua data segar ini ke View
        return view('manager.monitoring', compact(
            'kargoOffloadCount',
            'keluhanMasukCount',
            'kargoKritis',
            'auditTrail'
        ));
    }
}
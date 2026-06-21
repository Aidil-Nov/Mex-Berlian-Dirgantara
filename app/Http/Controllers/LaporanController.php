<?php

namespace App\Http\Controllers;

use App\Models\Kargo;
use App\Models\Laporan;
use App\Exports\KargoExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        $riwayat = Laporan::with('user')->latest()->get();
        return view('admin.kelola-laporan', compact('riwayat'));
    }

    public function generate(Request $request)
    {
        $query = Kargo::with(['pengirim', 'penerima', 'kotaAsal', 'kotaTujuan'])
            ->whereBetween('created_at', [$request->tgl_mulai . ' 00:00:00', $request->tgl_selesai . ' 23:59:59']);

        if ($request->status_filter !== 'semua') {
            $statusMap = ['diproses' => ['Entry', 'X-Ray', 'Loading', 'On Flight', 'Landing'], 'offload' => ['Offload'], 'selesai' => ['Selesai', 'Di Terima']];
            $query->whereIn('status_terakhir', $statusMap[$request->status_filter]);
        }
        $data = $query->get();

        $idLaporan = 'LAP-' . date('YmdHis');

        if ($request->input('format') === 'excel') {
            $path = 'laporan/' . $idLaporan . '.xlsx';
            Excel::store(new KargoExport($data), $path, 'public');
        } else {
            $path = 'laporan/' . $idLaporan . '.pdf';

            // PERBAIKAN DI SINI: Kirim variabel yang spesifik dan aman
            $pdf = Pdf::loadView('admin.laporan-pdf', [
                'data' => $data,
                'jenis_laporan' => ucfirst($request->jenis_laporan),
                'periode' => \Carbon\Carbon::parse($request->tgl_mulai)->format('d/m/Y') . ' s/d ' . \Carbon\Carbon::parse($request->tgl_selesai)->format('d/m/Y')
            ]);

            Storage::disk('public')->put($path, $pdf->output());
        }
        Laporan::create(['id_laporan' => $idLaporan, 'jenis_laporan' => $request->jenis_laporan, 'periode_label' => $request->tgl_mulai . ' s/d ' . $request->tgl_selesai, 'file_path' => $path, 'user_id' => Auth::id()]);

        return back()->with('success', 'Laporan berhasil dibuat!');
    }

    public function download($id)
    {
        $lap = Laporan::findOrFail($id);
        return Storage::disk('public')->download($lap->file_path);
    }
}
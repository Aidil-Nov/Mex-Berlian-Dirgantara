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
        // Mengambil riwayat cetak laporan
        $riwayat = Laporan::with(['user', 'validator'])->latest()->get();
        
        // Memisahkan laporan berdasarkan status untuk memudahkan tampilan di View
        $pending = $riwayat->where('status', 'pending');
        $validated = $riwayat->where('status', 'validated');

        if (Auth::user()->role === 'manajer_cabang') {
            return view('manager.laporan', compact('pending', 'validated'));
        }

        return view('admin.kelola-laporan', compact('pending', 'validated'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'jenis_laporan' => 'required',
        ]);

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
            $pdf = Pdf::loadView('admin.laporan-pdf', [
                'data' => $data,
                'jenis_laporan' => ucfirst($request->jenis_laporan),
                'periode' => \Carbon\Carbon::parse($request->tgl_mulai)->format('d/m/Y') . ' s/d ' . \Carbon\Carbon::parse($request->tgl_selesai)->format('d/m/Y')
            ]);
            Storage::disk('public')->put($path, $pdf->output());
        }

        // Menyimpan dengan status 'pending' (Wajib divalidasi manajer dulu)
        Laporan::create([
            'id_laporan' => $idLaporan, 
            'jenis_laporan' => $request->jenis_laporan, 
            'periode_label' => \Carbon\Carbon::parse($request->tgl_mulai)->format('d/m/Y') . ' s/d ' . \Carbon\Carbon::parse($request->tgl_selesai)->format('d/m/Y'), 
            'file_path' => $path, 
            'user_id' => Auth::id(),
            'status' => 'pending' 
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dibuat. Menunggu validasi Manajer.');
    }

    // METHOD BARU: Untuk Manajer Memvalidasi Laporan
    public function validateReport($id)
    {
        $laporan = Laporan::findOrFail($id);
        
        $laporan->update([
            'status' => 'validated',
            'validator_id' => Auth::id(),
            'validated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil divalidasi dan kini siap diunduh.');
    }

    public function download($id)
    {
        $lap = Laporan::findOrFail($id);
        
        // PENGAMANAN: Hanya bisa download jika sudah 'validated'
        if ($lap->status !== 'validated') {
            return back()->with('error', 'Akses ditolak. Laporan belum divalidasi oleh Manajer.');
        }
        
        if (Storage::disk('public')->exists($lap->file_path)) {
            return Storage::disk('public')->download($lap->file_path);
        }

        return back()->with('error', 'Berkas fisik tidak ditemukan.');
    }
}
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
        // Mengambil riwayat cetak laporan terbaru
        $riwayat = Laporan::with('user')->latest()->get();
        
        // Pengecekan Hak Akses untuk Tampilan Blade
        if (Auth::user()->role === 'manajer_cabang') {
            return view('manager.laporan', compact('riwayat'));
        }

        return view('admin.kelola-laporan', compact('riwayat'));
    }

    public function generate(Request $request)
    {
        // Validasi input tanggal agar tidak kosong saat di-generate
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'jenis_laporan' => 'required',
        ]);

        $query = Kargo::with(['pengirim', 'penerima', 'kotaAsal', 'kotaTujuan'])
            ->whereBetween('created_at', [$request->tgl_mulai . ' 00:00:00', $request->tgl_selesai . ' 23:59:59']);

        if ($request->status_filter !== 'semua') {
            $statusMap = [
                'diproses' => ['Entry', 'X-Ray', 'Loading', 'On Flight', 'Landing'], 
                'offload' => ['Offload'], 
                'selesai' => ['Selesai', 'Di Terima']
            ];
            $query->whereIn('status_terakhir', $statusMap[$request->status_filter]);
        }
        $data = $query->get();

        $idLaporan = 'LAP-' . date('YmdHis');

        if ($request->input('format') === 'excel') {
            $path = 'laporan/' . $idLaporan . '.xlsx';
            Excel::store(new KargoExport($data), $path, 'public');
        } else {
            $path = 'laporan/' . $idLaporan . '.pdf';

            // Menggunakan view laporan yang sudah ada
            $pdf = Pdf::loadView('admin.laporan-pdf', [
                'data' => $data,
                'jenis_laporan' => ucfirst($request->jenis_laporan),
                'periode' => \Carbon\Carbon::parse($request->tgl_mulai)->format('d/m/Y') . ' s/d ' . \Carbon\Carbon::parse($request->tgl_selesai)->format('d/m/Y')
            ]);

            Storage::disk('public')->put($path, $pdf->output());
        }

        // Menyimpan data log laporan ke database
        Laporan::create([
            'id_laporan' => $idLaporan, 
            'jenis_laporan' => $request->jenis_laporan, 
            'periode_label' => \Carbon\Carbon::parse($request->tgl_mulai)->format('d/m/Y') . ' s/d ' . \Carbon\Carbon::parse($request->tgl_selesai)->format('d/m/Y'), 
            'file_path' => $path, 
            'user_id' => Auth::id()
        ]);

        // Pengecekan Hak Akses untuk Arah Redirection setelah sukses
        if (Auth::user()->role === 'manajer_cabang') {
            return redirect()->route('manager.laporan')->with('success', 'Laporan Manajer berhasil dibuat!');
        }

        return redirect()->route('admin.kelola-laporan')->with('success', 'Laporan Admin berhasil dibuat!');
    }

    public function download($id)
    {
        $lap = Laporan::findOrFail($id);
        
        // Memastikan file fisik benar-benar ada di storage sebelum diunduh
        if (Storage::disk('public')->exists($lap->file_path)) {
            return Storage::disk('public')->download($lap->file_path);
        }

        return back()->with('error', 'Gagal mengunduh file. Berkas fisik tidak ditemukan di sistem penyimpanan.');
    }
}
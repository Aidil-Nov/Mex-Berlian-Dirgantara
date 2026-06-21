<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komplain;
use App\Models\Kargo;
use Illuminate\Support\Facades\Auth;

class KomplainController extends Controller
{
    // 1. Menampilkan Halaman
    public function index()
    {
        // Ambil riwayat komplain, urutkan dari yang terbaru
        $komplains = Komplain::with(['kargo', 'user'])->latest()->get();
        return view('admin.komplain', compact('komplains'));
    }

    // 2. API Internal untuk Cek Resi via Alpine.js (Tanpa Reload)
    public function cekResi(Request $request)
    {
        $resi = $request->query('resi');

        $kargo = Kargo::with(['pengirim', 'penerima', 'kotaAsal', 'kotaTujuan'])
            ->where('no_resi', $resi)
            ->first();

        if ($kargo) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'pengirim' => $kargo->pengirim->nama ?? '-',
                    'penerima' => $kargo->penerima->nama ?? '-',
                    'rute' => ($kargo->kotaAsal->nama_kota ?? '') . ' → ' . ($kargo->kotaTujuan->nama_kota ?? ''),
                    'status_kargo' => $kargo->status_terakhir
                ]
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Nomor Resi tidak ditemukan!'], 404);
    }

    // 3. Menyimpan Data Komplain
    public function store(Request $request)
    {
        $request->validate([
            'no_resi' => 'required|exists:kargo,no_resi',
            'nama_pelapor' => 'required|string|max:255',
            'hp_pelapor' => 'required|string|max:20',
            'email_pelapor' => 'nullable|email|max:255',
            'kategori' => 'required|in:keterlambatan,rusak,hilang,layanan',
            'tingkat_keparahan' => 'required|in:rendah,sedang,tinggi,kritis',
            'deskripsi' => 'required|string',
            'estimasi_klaim' => 'nullable|string|max:255',
            'channel' => 'required|in:telepon,whatsapp,email,langsung',
        ]);

        // Generate ID Otomatis (Format: COMP-001, COMP-002, dst)
        $lastKomplain = Komplain::orderBy('created_at', 'desc')->first();
        $lastIdNumber = $lastKomplain ? intval(substr($lastKomplain->id_komplain, 5)) : 0;
        $newId = 'COMP-' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);

        // Simpan ke Database
        Komplain::create([
            'id_komplain' => $newId,
            'no_resi' => $request->no_resi,
            'nama_pelapor' => $request->nama_pelapor,
            'hp_pelapor' => $request->hp_pelapor,
            'email_pelapor' => $request->email_pelapor,
            'kategori' => $request->kategori,
            'tingkat_keparahan' => $request->tingkat_keparahan,
            'deskripsi' => $request->deskripsi,
            'estimasi_klaim' => $request->estimasi_klaim,
            'id_user' => Auth::id(),
            'channel' => $request->channel,
            'status' => 'menunggu', // Default baru masuk
        ]);

        return redirect()->back()->with('success', "Komplain berhasil dicatat dengan ID Tiket: $newId");
    }
}
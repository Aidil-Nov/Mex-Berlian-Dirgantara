<?php

namespace App\Http\Controllers;

use App\Models\Komplain;
use Illuminate\Http\Request;

class ManagerKomplainController extends Controller
{
    /**
     * Menampilkan Halaman Indeks Komplain (Monitor Operasional)
     */
    public function index()
    {
        // Mengambil komplain yang statusnya masih 'menunggu' untuk dipantau secara umum
        $komplainMasuk = Komplain::with('kargo')
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        return view('manager.monitoring', compact('komplainMasuk'));
    }

    /**
     * TAMBAHAN: Menampilkan Halaman Validasi Keluhan Khusus
     */
    public function validasiIndex()
    {
        // Ambil komplain yang berstatus 'menunggu' (perlu tindakan segera)
        $komplainPending = Komplain::with('kargo')
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        // Ambil riwayat komplain yang sudah diproses atau selesai
        $komplainSelesai = Komplain::with('kargo')
            ->whereIn('status', ['diproses', 'selesai'])
            ->latest()
            ->take(10)
            ->get();

        return view('manager.validasi-komplain', compact('komplainPending', 'komplainSelesai'));
    }

    /**
     * Menyimpan Keputusan Final Tindakan Solusi Keluhan
     */
    public function updateSolusi(Request $request, $id)
    {
        $request->validate([
            'tindakan_solusi' => 'required|string|min:10',
        ], [
            'tindakan_solusi.required' => 'Instruksi tindakan solusi wajib diisi.',
            'tindakan_solusi.min'      => 'Berikan instruksi tindakan yang jelas (minimal 10 karakter).'
        ]);

        $komplain = Komplain::findOrFail($id);
        
        // Update data sesuai kriteria tugas
        $komplain->update([
            'tindakan_solusi' => $request->tindakan_solusi,
            'status'          => 'selesai' // Mengubah status dari 'menunggu' menjadi 'selesai'
        ]);

        // Mengembalikan ke halaman asal setelah sukses
        return redirect()->back()->with('success', 'Keputusan solusi keluhan berhasil divalidasi!');
    }
}
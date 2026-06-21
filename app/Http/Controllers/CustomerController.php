<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Tampilkan Halaman & Data
    public function index(Request $request)
    {
        $query = Customer::query();

        // Fitur Pencarian berdasarkan Nama atau No HP
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('no_hp', 'like', "%{$search}%");
        }

        // Gunakan pagination agar web tidak berat jika customer sudah ribuan
        $customers = $query->orderBy('created_at', 'desc')->paginate(10);

        // Asumsi nama file view Anda nanti adalah 'admin.customer'
        return view('admin.customer', compact('customers'));
    }

    // 2. Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20|unique:customers,no_hp', // Cegah nomor ganda
            'tipe_cust' => 'required|in:retail,corporate',
            'alamat' => 'required|string',
        ]);

        Customer::create($request->all());

        return redirect()->back()->with('success', 'Data Customer berhasil ditambahkan!');
    }

    // 3. Update Data Lama
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20|unique:customers,no_hp,' . $id, // Pengecualian unik untuk dirinya sendiri
            'tipe_cust' => 'required|in:retail,corporate',
            'alamat' => 'required|string',
        ]);

        $customer->update($request->all());

        return redirect()->back()->with('success', 'Data Customer berhasil diperbarui!');
    }

    // 4. Hapus Data
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Opsional: Cek apakah customer ini sedang dipakai di tabel Kargo sebelum dihapus
        if ($customer->kargoDikirim()->exists() || $customer->kargoDiterima()->exists()) {
            return redirect()->back()->with('error', 'Customer tidak dapat dihapus karena memiliki riwayat pengiriman kargo!');
        }

        $customer->delete();

        return redirect()->back()->with('success', 'Data Customer berhasil dihapus!');
    }
}
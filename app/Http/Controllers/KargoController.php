<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kargo;
use App\Models\Customer;
use App\Models\MasterKota;
use App\Models\MasterJenisBarang;
use App\Models\HistoryStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KargoController extends Controller
{
    /**
     * Menampilkan halaman form Kelola Data Kargo
     */
    public function create()
    {
        // Kunci kota asal hanya untuk Pontianak
        $kota_asal = MasterKota::where('nama_kota', 'like', '%Pontianak%')->get();

        // Ambil semua kota tujuan KECUALI Pontianak, dan urutkan sesuai abjad agar rapi
        $kota_tujuan = MasterKota::where('nama_kota', 'not like', '%Pontianak%')
            ->orderBy('nama_kota', 'asc')
            ->get();

        $jenis_barang = MasterJenisBarang::all();

        // Generate nomor resi sementara
        $no_resi = 'MEX-' . date('ym') . rand(1000, 9999);

        return view('admin.kelola-data-kargo', compact('kota_asal', 'kota_tujuan', 'jenis_barang', 'no_resi'));
    }

    /**
     * Memproses penyimpanan data kargo baru
     */
    public function store(Request $request)
    {
        // 1. Validasi Input dari Form
        $request->validate([
            // Validasi Area 1: Pengirim
            'nama_pengirim' => 'required|string|max:255',
            'hp_pengirim' => 'required|string|max:20',
            'alamat_pengirim' => 'required|string',
            'tipe_customer' => 'required|in:retail,corporate',

            // Validasi Area 2: Penerima
            'nama_penerima' => 'required|string|max:255',
            'hp_penerima' => 'required|string|max:20',
            'alamat_penerima' => 'required|string',

            // Validasi Area 3: Kargo
            'berat' => 'required|numeric|min:0.1',
            'isi_barang' => 'required|string|max:255',
            'jenis_barang' => 'required|exists:master_jenis_barang,id',
            'kota_asal' => 'required|exists:master_kota,id',
            'kota_tujuan' => 'required|exists:master_kota,id',
        ]);

        // 2. Mulai Database Transaction
        DB::beginTransaction();

        try {
            // A. Simpan Data Pengirim ke tabel customers
            $pengirim = Customer::create([
                'nama' => $request->nama_pengirim,
                'no_hp' => $request->hp_pengirim,
                'alamat' => $request->alamat_pengirim,
                'tipe_cust' => $request->tipe_customer,
            ]);

            // B. Simpan Data Penerima ke tabel customers (Diasumsikan tipe retail)
            $penerima = Customer::create([
                'nama' => $request->nama_penerima,
                'no_hp' => $request->hp_penerima,
                'alamat' => $request->alamat_penerima,
                'tipe_cust' => 'retail',
            ]);

            // C. Generate Resi Final
            $no_resi = 'MEX-' . date('ym') . rand(1000, 9999);

            // D. Simpan Data Kargo Utama
            $kargo = Kargo::create([
                'no_resi' => $no_resi,
                'id_pengirim' => $pengirim->id,
                'id_penerima' => $penerima->id,
                'id_kota_asal' => $request->kota_asal,
                'id_kota_tujuan' => $request->kota_tujuan,
                'id_jenis' => $request->jenis_barang,
                'id_user' => Auth::id(), // ID Admin yang sedang login
                'berat' => $request->berat,
                'isi_barang' => $request->isi_barang,
                'status_terakhir' => 'Entry',
                'tgl_terima' => now(),
            ]);

            // E. Catat Log History Status Pertama (Otomatis Entry)
            HistoryStatus::create([
                'no_resi' => $kargo->no_resi,
                'id_user' => Auth::id(),
                'status' => 'Entry',
                'keterangan' => 'Paket diterima di fasilitas cabang ' . $kargo->kotaAsal->nama_kota,
            ]);

            // Jika semua berhasil, simpan permanen ke database
            DB::commit();

            // Kembalikan ke halaman form dengan pesan sukses
            return redirect()->route('admin.kelola-data-kargo')->with('success', "Kargo berhasil disimpan! Nomor Resi: {$no_resi}");

        } catch (\Exception $e) {
            // Jika ada satu saja yang error, batalkan semua insert data!
            DB::rollBack();

            // Kembalikan ke halaman form dengan pesan error dan input sebelumnya tidak hilang
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }
}
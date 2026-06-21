<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KargoEntrySeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil ID Admin Operasional (Ahmad Fauzi) secara otomatis dari database
        $admin = DB::table('users')->where('username', 'admin')->first();
        $adminId = $admin ? $admin->id : 1;

        // Menyiapkan 3 data kargo dummy berstatus 'Entry'
        $kargoData = [
            [
                'no_resi' => 'MEX-26061001',
                'id_pengirim' => 1, // Rina Wijaya (dari MasterDataSeeder)
                'id_penerima' => 2, // PT. Maju Jaya
                'id_kota_asal' => 1, // Pontianak (PNK)
                'id_kota_tujuan' => 2, // Jakarta (CGK)
                'id_jenis' => 1, // General Cargo
                'id_user' => $adminId,
                'berat' => 15.5,
                'isi_barang' => 'Dokumen & Pakaian Konveksi',
                'status_terakhir' => 'Entry',
                'no_penerbangan' => null,
                'maskapai' => null,
                'tgl_terima' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_resi' => 'MEX-26061002',
                'id_pengirim' => 2,
                'id_penerima' => 1,
                'id_kota_asal' => 1, // Pontianak (PNK)
                'id_kota_tujuan' => 3, // Surabaya (SUB)
                'id_jenis' => 2, // Perishable Goods
                'id_user' => $adminId,
                'berat' => 8.2,
                'isi_barang' => 'Kosmetik & Skincare',
                'status_terakhir' => 'Entry',
                'no_penerbangan' => null,
                'maskapai' => null,
                'tgl_terima' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_resi' => 'MEX-26061003',
                'id_pengirim' => 1,
                'id_penerima' => 2,
                'id_kota_asal' => 1, // Pontianak (PNK)
                'id_kota_tujuan' => 2, // Jakarta (CGK)
                'id_jenis' => 3, // Valuable Goods
                'id_user' => $adminId,
                'berat' => 2.0,
                'isi_barang' => 'Suku Cadang Elektronik',
                'status_terakhir' => 'Entry',
                'no_penerbangan' => null,
                'maskapai' => null,
                'tgl_terima' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($kargoData as $kargo) {
            // 1. Masukkan data ke tabel kargo utama
            DB::table('kargo')->insert($kargo);

            // 2. Masukkan data ke tabel riwayat status (wajib ada log awal saat kargo dibuat)
            DB::table('history_status')->insert([
                'no_resi' => $kargo['no_resi'],
                'id_user' => $kargo['id_user'],
                'status' => 'Entry',
                'keterangan' => 'Paket telah diterima dan didaftarkan di warehouse asal.',
                'waktu_update' => now(),
            ]);
        }
    }
}
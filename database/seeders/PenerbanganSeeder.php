<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MasterKota;
use Carbon\Carbon;

class MasterPenerbanganSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama
        DB::table('master_penerbangan')->delete();

        // AMBIL ID KOTA DARI DATABASE BERDASARKAN KODE IATA
        $kotaList = MasterKota::all();
        $id_pnk = null;
        $id_cgk = null;

        foreach ($kotaList as $kota) {
            if (str_contains($kota->nama_kota, '(PNK)')) {
                $id_pnk = $kota->id;
            } elseif (str_contains($kota->nama_kota, '(CGK)')) {
                $id_cgk = $kota->id;
            }
        }

        // Jika salah satu kota tidak ditemukan, hentikan seeder
        if (!$id_pnk || !$id_cgk) {
            $this->command->error("Error: Pastikan data 'Pontianak (PNK)' dan 'Jakarta (CGK)' ada di tabel master_kota!");
            return;
        }

        $dataPenerbangan = [
            // Rute: Pontianak (PNK) ke Jakarta (CGK)
            [
                'no_penerbangan' => 'GA-502',
                'maskapai' => 'Garuda Indonesia',
                'jenis_pesawat' => 'Komersil',
                'tipe_pesawat' => 'Boeing 737-800',
                'id_kota_asal' => $id_pnk,
                'id_kota_tujuan' => $id_cgk,
                'status_penerbangan' => 'Scheduled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_penerbangan' => 'JT-715',
                'maskapai' => 'Lion Air',
                'jenis_pesawat' => 'Komersil',
                'tipe_pesawat' => 'Boeing 737-900ER',
                'id_kota_asal' => $id_pnk,
                'id_kota_tujuan' => $id_cgk,
                'status_penerbangan' => 'Active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Rute: Jakarta (CGK) ke Pontianak (PNK)
            [
                'no_penerbangan' => 'ID-6220',
                'maskapai' => 'Batik Air',
                'jenis_pesawat' => 'Komersil',
                'tipe_pesawat' => 'Airbus A320',
                'id_kota_asal' => $id_cgk,
                'id_kota_tujuan' => $id_pnk,
                'status_penerbangan' => 'Scheduled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('master_penerbangan')->insert($dataPenerbangan);
        $this->command->info("Data dummy MasterPenerbangan berhasil dimasukkan!");
    }
}
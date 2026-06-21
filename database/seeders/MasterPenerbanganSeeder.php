<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterPenerbanganSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama agar tidak menumpuk/error unique
        DB::table('master_penerbangan')->delete();

        $dataPenerbangan = [
            // Rute: Pontianak (1) ke Jakarta (2)
            [
                'no_penerbangan' => 'GA-502',
                'maskapai' => 'Garuda Indonesia',
                'jenis_pesawat' => 'Komersil',
                'tipe_pesawat' => 'Boeing 737-800',
                'id_kota_asal' => 1,
                'id_kota_tujuan' => 2,
                'status_penerbangan' => 'Scheduled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_penerbangan' => 'JT-715',
                'maskapai' => 'Lion Air',
                'jenis_pesawat' => 'Komersil',
                'tipe_pesawat' => 'Boeing 737-900ER',
                'id_kota_asal' => 1,
                'id_kota_tujuan' => 2,
                'status_penerbangan' => 'Active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_penerbangan' => 'QG-423',
                'maskapai' => 'Citilink',
                'jenis_pesawat' => 'Komersil',
                'tipe_pesawat' => 'Airbus A320',
                'id_kota_asal' => 1,
                'id_kota_tujuan' => 2,
                'status_penerbangan' => 'Landed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Rute: Jakarta (2) ke Pontianak (1)
            [
                'no_penerbangan' => 'ID-6220',
                'maskapai' => 'Batik Air',
                'jenis_pesawat' => 'Komersil',
                'tipe_pesawat' => 'Airbus A320',
                'id_kota_asal' => 2,
                'id_kota_tujuan' => 1,
                'status_penerbangan' => 'Scheduled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_penerbangan' => 'GA-505',
                'maskapai' => 'Garuda Indonesia',
                'jenis_pesawat' => 'Komersil',
                'tipe_pesawat' => 'Boeing 737-800',
                'id_kota_asal' => 2,
                'id_kota_tujuan' => 1,
                'status_penerbangan' => 'Cancelled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Rute: Pontianak (1) ke Surabaya (3)
            [
                'no_penerbangan' => 'JT-832',
                'maskapai' => 'Lion Air',
                'jenis_pesawat' => 'Komersil',
                'tipe_pesawat' => 'Boeing 737-800',
                'id_kota_asal' => 1,
                'id_kota_tujuan' => 3,
                'status_penerbangan' => 'Scheduled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Pesawat Kargo Khusus (Freighter)
            [
                'no_penerbangan' => 'MYindo-101',
                'maskapai' => 'My Indo Airlines',
                'jenis_pesawat' => 'Kargo (Freighter)',
                'tipe_pesawat' => 'Boeing 737-300F',
                'id_kota_asal' => 2,
                'id_kota_tujuan' => 1,
                'status_penerbangan' => 'Scheduled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('master_penerbangan')->insert($dataPenerbangan);
    }
}
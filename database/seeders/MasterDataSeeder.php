<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Pengguna (User)
        DB::table('users')->insert([
            [
                'nama' => 'Ferdian Iswara',
                'username' => 'manager',
                'email' => 'manager@mex.com',
                'password' => Hash::make('password'),
                'role' => 'manajer_cabang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'username' => 'admin',
                'email' => 'admin@mex.com',
                'password' => Hash::make('password'),
                'role' => 'admin_operasional',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 2. Buat Data Master Kota (Daftar Lengkap Bandara Indonesia)
        $kota = [
            // Kalimantan (Pusat Operasional)
            ['nama_kota' => 'Pontianak (PNK)'],
            ['nama_kota' => 'Balikpapan (BPN)'],
            ['nama_kota' => 'Banjarmasin (BDJ)'],
            ['nama_kota' => 'Palangkaraya (PKY)'],
            ['nama_kota' => 'Samarinda (AAP)'],
            ['nama_kota' => 'Tarakan (TRK)'],
            // Jawa & Bali
            ['nama_kota' => 'Jakarta - Soekarno Hatta (CGK)'],
            ['nama_kota' => 'Jakarta - Halim (HLP)'],
            ['nama_kota' => 'Surabaya (SUB)'],
            ['nama_kota' => 'Bandung (BDO)'],
            ['nama_kota' => 'Semarang (SRG)'],
            ['nama_kota' => 'Yogyakarta (YIA)'],
            ['nama_kota' => 'Solo (SOC)'],
            ['nama_kota' => 'Bali (DPS)'],
            // Sumatera
            ['nama_kota' => 'Medan (KNO)'],
            ['nama_kota' => 'Batam (BTH)'],
            ['nama_kota' => 'Padang (PDG)'],
            ['nama_kota' => 'Pekanbaru (PKU)'],
            ['nama_kota' => 'Palembang (PLM)'],
            ['nama_kota' => 'Jambi (DJB)'],
            ['nama_kota' => 'Bengkulu (BKS)'],
            ['nama_kota' => 'Bandar Lampung (TKG)'],
            ['nama_kota' => 'Banda Aceh (BTJ)'],
            ['nama_kota' => 'Pangkal Pinang (PGK)'],
            // Sulawesi & Maluku
            ['nama_kota' => 'Makassar (UPG)'],
            ['nama_kota' => 'Manado (MDC)'],
            ['nama_kota' => 'Kendari (KDI)'],
            ['nama_kota' => 'Palu (PLW)'],
            ['nama_kota' => 'Ambon (AMQ)'],
            ['nama_kota' => 'Ternate (TTE)'],
            // Nusa Tenggara & Papua
            ['nama_kota' => 'Lombok (LOP)'],
            ['nama_kota' => 'Kupang (KOE)'],
            ['nama_kota' => 'Jayapura (DJJ)'],
            ['nama_kota' => 'Sorong (SOQ)'],
            ['nama_kota' => 'Timika (TIM)'],
            ['nama_kota' => 'Merauke (MKQ)'],
        ];
        
        foreach ($kota as $k) {
            $k['created_at'] = now();
            $k['updated_at'] = now();
            DB::table('master_kota')->insert($k);
        }

        // 3. Buat Data Master Jenis Barang
        $jenis = [
            ['nama_jenis' => 'General Cargo'],
            ['nama_jenis' => 'Perishable Goods (Mudah Rusak)'],
            ['nama_jenis' => 'Valuable Goods (Barang Berharga)'],
            ['nama_jenis' => 'Dangerous Goods'],
        ];

        foreach ($jenis as $j) {
            $j['created_at'] = now();
            $j['updated_at'] = now();
            DB::table('master_jenis_barang')->insert($j);
        }

        // 4. Buat 2 Customer Dummy (Sebagai pancingan awal)
        DB::table('customers')->insert([
            [
                'nama' => 'Rina Wijaya',
                'alamat' => 'Jl. Ayani No. 1, Pontianak',
                'no_hp' => '081234567890',
                'tipe_cust' => 'retail',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Maju Jaya',
                'alamat' => 'Jl. Sudirman No. 10, Jakarta',
                'no_hp' => '081987654321',
                'tipe_cust' => 'corporate',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan model User di-import

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Operasional
        User::create([
            'name' => 'Admin Operasional',
            'username' => 'admin_ops',
            'email' => 'admin@mex.com',
            'password' => Hash::make('password123'), // Password default
            'role' => 'admin_operasional',
        ]);

        // 2. Akun Manajer Cabang
        User::create([
            'name' => 'Bapak Manajer',
            'username' => 'manajer',
            'email' => 'manajer@mex.com',
            'password' => Hash::make('password123'),
            'role' => 'manajer_cabang',
        ]);
    }
}
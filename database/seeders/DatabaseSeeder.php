<?php

namespace Database\Seeders;

use Database\Seeders\MasterDataSeeder;
use Database\Seeders\PenerbanganSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\KargoEntrySeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MasterDataSeeder::class,
            MasterPenerbanganSeeder::class,
            KargoEntrySeeder::class,
        ]);
    }
}
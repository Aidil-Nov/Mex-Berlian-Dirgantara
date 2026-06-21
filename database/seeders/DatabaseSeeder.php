<?php

namespace Database\Seeders;

use Database\Seeders\MasterDataSeeder;
use Database\Seeders\PenerbanganSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MasterDataSeeder::class,
            PenerbanganSeeder::class,
            KargoEntrySeeder::class,
        ]);
    }
}
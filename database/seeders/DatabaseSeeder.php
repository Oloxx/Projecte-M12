<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ProvinciaSeeder::class);
        $this->call(ComarcaSeeder::class);
        $this->call(PoblacioSeeder::class);
        $this->call(TipologiaSeeder::class);
        $this->call(CicleSeeder::class);
        $this->call(RolSeeder::class);
    }
}

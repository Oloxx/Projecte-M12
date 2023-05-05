<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


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

        DB::table('users')->insert([
            'name' => 'Random',
            'Cognoms' => 'Random',
            'email' => 'random@gmail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$ZaOY70N1hPdSD0s2GsnpIuXxG0PlCm0SLBIzzjgDJtS6UHMEZjPiO',
            'rol_id' => 1,
            'cicle_id' => 5,
            'language' => 'ca',
            'remember_token' => NULL,
            'created_at' => NULL,
            'updated_at' => NULL

        ]);

        $this->call(CategoriaSeeder::class);
        $this->call(SectorSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(ContacteSeeder::class);
        $this->call(CollaboracioSeeder::class);
    }

}

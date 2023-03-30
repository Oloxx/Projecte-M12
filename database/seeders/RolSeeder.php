<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/csv/Rols.csv"), "r");

        while (($data = fgetcsv($csvFile, 2, ",")) !== false) {
            Rol::create([
                "rol" => $data['0'],
                "created_at" => NULL,
                "updated_at" => NULL
            ]);
        }

        fclose($csvFile);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Provincia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/csv/Provincies.csv"), "r");

        while (($data = fgetcsv($csvFile, 4, ",")) !== false) {
            Provincia::create([
                "nom" => $data['0'],
                "created_at" => NULL,
                "updated_at" => NULL
            ]);
        }

        fclose($csvFile);
    }
}

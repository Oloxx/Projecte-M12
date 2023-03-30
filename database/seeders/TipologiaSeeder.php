<?php

namespace Database\Seeders;

use App\Models\Tipologia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipologiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/csv/Tipologies.csv"), "r");

        while (($data = fgetcsv($csvFile, 3, ",")) !== false) {
            Tipologia::create([
                "nom" => $data['0'],
                "created_at" => NULL,
                "updated_at" => NULL
            ]);
        }

        fclose($csvFile);
    }
}

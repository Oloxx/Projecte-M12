<?php

namespace Database\Seeders;

use App\Models\Comarca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/csv/Comarques.csv"), "r");

        while (($data = fgetcsv($csvFile, 46, ",")) !== false) {
            Comarca::create([
                "nom" => $data['0'],
                "provincia_id" => $data['1'],
                "created_at" => NULL,
                "updated_at" => NULL
            ]);
        }

        fclose($csvFile);
    }
}

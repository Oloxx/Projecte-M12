<?php

namespace Database\Seeders;

use App\Models\Cicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/csv/Cicles.csv"), "r");

        while (($data = fgetcsv($csvFile, 13, ",")) !== false) {
            Cicle::create([
                "nom" => $data['0'],
                "codi" => $data['1'],
                "tipologia_id" => $data['2'],
                "created_at" => NULL,
                "updated_at" => NULL
            ]);
        }

        fclose($csvFile);
    }
}

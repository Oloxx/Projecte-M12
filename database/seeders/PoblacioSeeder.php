<?php

namespace Database\Seeders;

use App\Models\Poblacio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoblacioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/csv/Poblacions.csv"), "r");

        while (($data = fgetcsv($csvFile, 946, ",")) !== false) {
            Poblacio::create([
                "nom" => $data['0'],
                "comarca_id" => $data['1'],
                "created_at" => NULL,
                "updated_at" => NULL
            ]);
        }

        fclose($csvFile);
    }
}

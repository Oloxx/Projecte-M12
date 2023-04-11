<?php

namespace Database\Seeders;

use App\Models\Contacte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContacteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/csv/Contactes.csv"), "r");

        while (($data = fgetcsv($csvFile, 946, ",")) !== false) {
            Contacte::create([
                "nom" => $data['0'],
                "cognoms" => $data['1'],
                "movil" => $data['2'],
                "email" => $data['3'],
                "empresa_id" => $data['4'],
                "created_at" => NULL,
                "updated_at" => NULL
            ]);
        }

        fclose($csvFile);
    }
}

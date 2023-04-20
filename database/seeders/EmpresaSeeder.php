<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/csv/Empresa.csv"), "r");

        while (($data = fgetcsv($csvFile, 946, ",")) !== false) {
            Empresa::create([
                "nom" => $data['0'],
                "telefon" => $data['1'],
                "web" => $data['2'],
                "email" => $data['3'],
                "poblacio_id" => $data['4'],
                "categoria_id" => $data['5'],
                "sector_id" => $data['6'],
                "created_at" => NULL,
                "updated_at" => NULL
            ]);
        }

        fclose($csvFile);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Collaboracio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollaboracioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/csv/Collaboracions.csv"), "r");

        while (($data = fgetcsv($csvFile, 946, ",")) !== false) {
            Collaboracio::create([
                "any" => $data['0'],
                "empresa_id" => $data['1'],
                "contacte_id" => $data['2'],
                "cicle_id" => $data['3'],
                "user_id" => $data['4'],
                "stars" => $data['5'],
                "comentaris" => $data['6'],
                "created_at" => NULL,
                "updated_at" => NULL
            ]);
        }

        fclose($csvFile);
    }
}

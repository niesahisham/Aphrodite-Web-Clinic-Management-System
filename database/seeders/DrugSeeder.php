<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Drug; // 🌟 Make sure to import your team's Drug model

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drugs = [
            ['name' => 'Paracetamol', 'description' => '500mg - For pain relief and fever reduction.'],
            ['name' => 'Amoxicillin', 'description' => '250mg - Antibiotic for bacterial infections.'],
            ['name' => 'Ibuprofen', 'description' => '400mg - Anti-inflammatory painkiller.'],
            ['name' => 'Cetirizine', 'description' => '10mg - Antihistamine for allergy relief.'],
            ['name' => 'Metformin', 'description' => '500mg - For blood sugar management.'],
        ];

        foreach ($drugs as $drug) {
            // updateOrCreate prevents duplicate entry crashes if run twice
            Drug::updateOrCreate(
                ['name' => $drug['name']], 
                ['description' => $drug['description']]
            );
        }
    }
}

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
            [
                'name' => 'Paracetamol',
                'category' => 'Analgesic',
                'dosage_form' => 'Tablet',
                'strength' => '500mg',
                'unit_price' => '0.50'
            ],
            [
                'name' => 'Amoxicillin',
                'category' => 'Antibiotic',
                'dosage_form' => 'Capsule',
                'strength' => '250mg',
                'unit_price' => '1.20'
            ],
            [
                'name' => 'Ibuprofen',
                'category' => 'NSAID',
                'dosage_form' => 'Tablet',
                'strength' => '400mg',
                'unit_price' => '0.80'
            ],
            [
                'name' => 'Cetirizine',
                'category' => 'Antihistamine',
                'dosage_form' => 'Tablet',
                'strength' => '10mg',
                'unit_price' => '0.60'
            ],
            [
                'name' => 'Metformin',
                'category' => 'Antidiabetic',
                'dosage_form' => 'Tablet',
                'strength' => '500mg',
                'unit_price' => '1.50'
            ],
            [
                'name' => 'Penicillin',
                'category' => 'Antibiotic',
                'dosage_form' => 'Tablet',
                'strength' => '250mg',
                'unit_price' => '1.50'
            ]
        ];

        foreach ($drugs as $drug) {
            // Uniquely identify the record using name + strength to prevent database crashes
            Drug::updateOrCreate(
                [
                    'name' => $drug['name'], 
                    'strength' => $drug['strength']
                ], 
                [
                    'category' => $drug['category'],
                    'dosage_form' => $drug['dosage_form'],
                    'unit_price' => $drug['unit_price']
                ]
            );
        }
    }
}

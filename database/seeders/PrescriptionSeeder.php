<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\User;
use App\Models\Patient;
use App\Models\Drug;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Grab an existing Doctor, Patient, and Drug from your database
        $doctor = User::where('role', 'doctor')->first();
        $patient = Patient::first();
        $paracetamol = Drug::where('name', 'Paracetamol')->first();
        $amoxicillin = Drug::where('name', 'Amoxicillin')->first();

        // 🛡️ Safety Check: Only seed if we have a doctor and a patient available
        if ($doctor && $patient) {
            
            // 2. Create the Parent Prescription
            $prescription = Prescription::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'status' => 'active', // matches your state machine tracks
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Attach Child Prescription Items linked to the parent prescription
            if ($paracetamol) {
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'drug_id' => $paracetamol->id,
                    'dosage' => '2 tablets',
                    'frequency' => 'Three times a day after meals',
                    'duration_days' => '3 to 5 days', // Text-compatible format we fixed!
                ]);
            }

            if ($amoxicillin) {
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'drug_id' => $amoxicillin->id,
                    'dosage' => '1 capsule',
                    'frequency' => 'Twice a day',
                    'duration_days' => '7 days',
                ]);
            }
        }
    }
}

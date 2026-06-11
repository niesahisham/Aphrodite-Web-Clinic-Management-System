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
        // 1. Grab dependencies (Doctor)
        $doctor = User::where('role', 'doctor')->first();
        
        // Grab up to 3 distinct patients to distribute prescriptions naturally
        $patients = Patient::take(3)->get();
        $patient1 = $patients->get(0) ?? Patient::first();
        $patient2 = $patients->get(1) ?? $patient1;
        $patient3 = $patients->get(2) ?? $patient1;

        // Grab Drugs setup from your DrugSeeder
        $paracetamol = Drug::where('name', 'Paracetamol')->first();
        $amoxicillin = Drug::where('name', 'Amoxicillin')->first();
        $ibuprofen = Drug::where('name', 'Ibuprofen')->first();
        $cetirizine = Drug::where('name', 'Cetirizine')->first();

        // 🛡️ Safety Check: Exit silently if tables are empty
        if (!$doctor || !$patient1) {
            return;
        }

        // ==========================================
        // 📑 PRESCRIPTION 1: Active Multi-Drug Order
        // ==========================================
        $prescription1 = Prescription::create([
            'patient_id' => $patient1->id,
            'doctor_id' => $doctor->id,
            'status' => 'active',
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1),
        ]);

        if ($paracetamol) {
            PrescriptionItem::create([
                'prescription_id' => $prescription1->id,
                'drug_id' => $paracetamol->id,
                'dosage' => '2 tablets',
                'frequency' => 'Three times a day after meals',
                'duration_days' => '3 to 5 days',
            ]);
        }
        if ($cetirizine) {
            PrescriptionItem::create([
                'prescription_id' => $prescription1->id,
                'drug_id' => $cetirizine->id,
                'dosage' => '1 tablet',
                'frequency' => 'Once daily before sleep',
                'duration_days' => '7 days',
            ]);
        }

        // ==========================================
        // 📑 PRESCRIPTION 2: Completed Antibiotic Course
        // ==========================================
        $prescription2 = Prescription::create([
            'patient_id' => $patient2->id,
            'doctor_id' => $doctor->id,
            'status' => 'completed',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(3),
        ]);

        if ($amoxicillin) {
            PrescriptionItem::create([
                'prescription_id' => $prescription2->id,
                'drug_id' => $amoxicillin->id,
                'dosage' => '1 capsule',
                'frequency' => 'Every 8 hours',
                'duration_days' => '7 days',
            ]);
        }

        // ==========================================
        // 📑 PRESCRIPTION 3: Administered Pain Relief
        // ==========================================
        $prescription3 = Prescription::create([
            'patient_id' => $patient3->id,
            'doctor_id' => $doctor->id,
            'status' => 'administered',
            'created_at' => now()->subHours(4),
            'updated_at' => now()->subHours(4),
        ]);

        if ($ibuprofen) {
            PrescriptionItem::create([
                'prescription_id' => $prescription3->id,
                'drug_id' => $ibuprofen->id,
                'dosage' => '1 tablet',
                'frequency' => 'Twice a day as needed',
                'duration_days' => '5 days',
            ]);
        }
    }
}

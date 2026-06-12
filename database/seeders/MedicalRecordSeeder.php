<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $emma = DB::table('patients')->where('patient_code', 'P001')->first();
        $james = DB::table('patients')->where('patient_code', 'P002')->first();
        $olivia = DB::table('patients')->where('patient_code', 'P003')->first();

        if (!$emma || !$james || !$olivia) {
            return;
        }

        $emmaAppointment = DB::table('appointments')
            ->where('patient_id', $emma->id)
            ->whereDate('scheduled_at', Carbon::today())
            ->first();

        $jamesAppointment = DB::table('appointments')
            ->where('patient_id', $james->id)
            ->whereDate('scheduled_at', Carbon::today()->subDays(1))
            ->first();

        $oliviaAppointment = DB::table('appointments')
            ->where('patient_id', $olivia->id)
            ->whereDate('scheduled_at', Carbon::today()->subDays(3))
            ->first();

        $records = [
            [
                'appointment' => $emmaAppointment,
                'diagnosis' => 'Viral fever',
                'symptoms' => 'Fever, sore throat, headache, and body ache.',
                'treatment_notes' => 'Advised rest, fluid intake, and fever monitoring. Follow-up appointment arranged if fever continues.',
                'visit_date' => Carbon::today()->setTime(9, 20),
            ],
            [
                'appointment' => $jamesAppointment,
                'diagnosis' => 'Acute upper respiratory tract infection',
                'symptoms' => 'Persistent cough, sore throat, blocked nose, and mild fatigue.',
                'treatment_notes' => 'Prescribed cough syrup and advised patient to rest, hydrate, and return if symptoms worsen.',
                'visit_date' => Carbon::today()->subDays(1)->setTime(15, 20),
            ],
            [
                'appointment' => $oliviaAppointment,
                'diagnosis' => 'Mild allergic reaction',
                'symptoms' => 'Skin itchiness, redness, and mild swelling after latex exposure.',
                'treatment_notes' => 'Advised patient to avoid latex exposure and monitor for breathing difficulty. Antihistamine recommended.',
                'visit_date' => Carbon::today()->subDays(3)->setTime(10, 50),
            ],
        ];

        foreach ($records as $record) {
            if (!$record['appointment']) {
                continue;
            }

            DB::table('medical_records')->updateOrInsert(
                ['appointment_id' => $record['appointment']->id],
                [
                    'patient_id' => $record['appointment']->patient_id,
                    'doctor_id' => $record['appointment']->doctor_id,
                    'appointment_id' => $record['appointment']->id,
                    'diagnosis' => $record['diagnosis'],
                    'symptoms' => $record['symptoms'],
                    'treatment_notes' => $record['treatment_notes'],
                    'visit_date' => $record['visit_date'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $doctor = DB::table('users')->where('email', 'doctor@test.com')->first();
        $receptionist = DB::table('users')->where('email', 'receptionist@test.com')->first();

        $emma = DB::table('patients')->where('patient_code', 'P001')->first();
        $james = DB::table('patients')->where('patient_code', 'P002')->first();
        $olivia = DB::table('patients')->where('patient_code', 'P003')->first();
        $william = DB::table('patients')->where('patient_code', 'P004')->first();
        $sophia = DB::table('patients')->where('patient_code', 'P005')->first();

        if (!$doctor || !$receptionist || !$emma || !$james || !$olivia || !$william || !$sophia) {
            return;
        }

        $appointments = [
            [
                'patient_id' => $emma->id,
                'doctor_id' => $doctor->id,
                'booked_by' => $receptionist->id,
                'appointment_type' => 'Consultation',
                'scheduled_at' => Carbon::today()->setTime(9, 0),
                'status' => 'waiting',
                'reason' => 'Fever and sore throat',
                'notes' => 'Patient reported mild fever since yesterday.',
            ],
            [
                'patient_id' => $james->id,
                'doctor_id' => $doctor->id,
                'booked_by' => $receptionist->id,
                'appointment_type' => 'Follow-up',
                'scheduled_at' => Carbon::today()->setTime(9, 30),
                'status' => 'waiting',
                'reason' => 'Follow-up for cough medication',
                'notes' => 'Patient returned for follow-up consultation.',
            ],
            [
                'patient_id' => $olivia->id,
                'doctor_id' => $doctor->id,
                'booked_by' => $receptionist->id,
                'appointment_type' => 'Health Check',
                'scheduled_at' => Carbon::tomorrow()->setTime(10, 0),
                'status' => 'confirmed',
                'reason' => 'Routine health check',
                'notes' => 'Annual health screening appointment.',
            ],
            [
                'patient_id' => $william->id,
                'doctor_id' => $doctor->id,
                'booked_by' => $receptionist->id,
                'appointment_type' => 'Consultation',
                'scheduled_at' => Carbon::tomorrow()->setTime(11, 0),
                'status' => 'waiting',
                'reason' => 'Back pain consultation',
                'notes' => 'Patient requested doctor consultation for lower back pain.',
            ],
            [
                'patient_id' => $sophia->id,
                'doctor_id' => $doctor->id,
                'booked_by' => $receptionist->id,
                'appointment_type' => 'Consultation',
                'scheduled_at' => Carbon::today()->addDays(2)->setTime(14, 30),
                'status' => 'confirmed',
                'reason' => 'Headache and tiredness',
                'notes' => 'Patient requested consultation if symptoms continue.',
            ],
            [
                'patient_id' => $james->id,
                'doctor_id' => $doctor->id,
                'booked_by' => $receptionist->id,
                'appointment_type' => 'Consultation',
                'scheduled_at' => Carbon::today()->subDays(1)->setTime(15, 0),
                'status' => 'completed',
                'reason' => 'Persistent cough',
                'notes' => 'Consultation completed yesterday.',
            ],
            [
                'patient_id' => $olivia->id,
                'doctor_id' => $doctor->id,
                'booked_by' => $receptionist->id,
                'appointment_type' => 'Consultation',
                'scheduled_at' => Carbon::today()->subDays(3)->setTime(10, 30),
                'status' => 'completed',
                'reason' => 'Allergic reaction',
                'notes' => 'Consultation completed three days ago.',
            ],
        ];

        foreach ($appointments as $appointment) {
            DB::table('appointments')->updateOrInsert(
                [
                    'patient_id' => $appointment['patient_id'],
                    'doctor_id' => $appointment['doctor_id'],
                    'scheduled_at' => $appointment['scheduled_at'],
                ],
                array_merge($appointment, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }
}

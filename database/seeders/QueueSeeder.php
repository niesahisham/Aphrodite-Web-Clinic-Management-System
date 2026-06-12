<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QueueSeeder extends Seeder
{
    public function run(): void
    {
        $emma = DB::table('patients')->where('patient_code', 'P001')->first();
        $james = DB::table('patients')->where('patient_code', 'P002')->first();
        $william = DB::table('patients')->where('patient_code', 'P004')->first();
        $doctor = DB::table('users')->where('email', 'doctor@test.com')->first();

        if (!$emma || !$james || !$william || !$doctor) {
            return;
        }

        DB::table('appointments')
            ->where('patient_id', $emma->id)
            ->where('doctor_id', $doctor->id)
            ->whereDate('scheduled_at', Carbon::today())
            ->update([
                'queue_no' => 1,
                'queue_status' => 'waiting',
                'checked_in_at' => Carbon::today()->setTime(8, 45),
                'called_at' => null,
                'completed_at' => null,
                'updated_at' => now(),
            ]);

        DB::table('appointments')
            ->where('patient_id', $james->id)
            ->where('doctor_id', $doctor->id)
            ->whereDate('scheduled_at', Carbon::today())
            ->update([
                'queue_no' => 2,
                'queue_status' => 'called',
                'checked_in_at' => Carbon::today()->setTime(9, 5),
                'called_at' => Carbon::today()->setTime(9, 25),
                'completed_at' => null,
                'updated_at' => now(),
            ]);

        DB::table('appointments')
            ->where('patient_id', $william->id)
            ->where('doctor_id', $doctor->id)
            ->whereDate('scheduled_at', Carbon::tomorrow())
            ->update([
                'queue_no' => 1,
                'queue_status' => 'waiting',
                'checked_in_at' => Carbon::tomorrow()->setTime(10, 45),
                'called_at' => null,
                'completed_at' => null,
                'updated_at' => now(),
            ]);

        DB::table('appointments')
            ->where('patient_id', $james->id)
            ->where('doctor_id', $doctor->id)
            ->whereDate('scheduled_at', Carbon::today()->subDays(1))
            ->update([
                'queue_no' => 1,
                'queue_status' => 'completed',
                'checked_in_at' => Carbon::today()->subDays(1)->setTime(14, 40),
                'called_at' => Carbon::today()->subDays(1)->setTime(14, 55),
                'completed_at' => Carbon::today()->subDays(1)->setTime(15, 25),
                'updated_at' => now(),
            ]);
    }
}

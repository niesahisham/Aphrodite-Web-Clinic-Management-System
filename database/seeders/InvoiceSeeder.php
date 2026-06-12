<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\Payment;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $receptionist = DB::table('users')->where('email', 'receptionist@test.com')->first();
        $james        = DB::table('patients')->where('patient_code', 'P002')->first();
        $olivia       = DB::table('patients')->where('patient_code', 'P003')->first();

        if (!$receptionist || !$james || !$olivia) {
            return;
        }

        $jamesAppointment = DB::table('appointments')
            ->where('patient_id', $james->id)
            ->where('status', 'completed')
            ->whereDate('scheduled_at', Carbon::today()->subDays(1))
            ->first();

        $oliviaAppointment = DB::table('appointments')
            ->where('patient_id', $olivia->id)
            ->where('status', 'completed')
            ->whereDate('scheduled_at', Carbon::today()->subDays(3))
            ->first();

        // ── INVOICE 1: PAID ──────────────────────────────────────────────
        // James Brown — yesterday's consultation, fully settled by cash
        if ($jamesAppointment) {
            $paid = Invoice::updateOrCreate(
                ['appointment_id' => $jamesAppointment->id],
                [
                    'invoice_number' => 'INV-JAMES001',
                    'patient_id'     => $james->id,
                    'handled_by'     => $receptionist->id,
                    'total_amount'   => 120.00,
                    'paid_amount'    => 120.00,
                    'payment_method' => 'cash',
                    'payment_status' => 'paid',
                    'issued_at'      => Carbon::today()->subDays(1)->setTime(16, 0),
                ]
            );

            // Matching payment record
            Payment::updateOrCreate(
                ['invoice_id' => $paid->id, 'payment_method' => 'cash'],
                [
                    'amount_paid' => 120.00,
                    'paid_at'     => Carbon::today()->subDays(1)->setTime(16, 5),
                ]
            );
        }

        // ── INVOICE 2: UNPAID ────────────────────────────────────────────
        // Olivia Martinez — consultation 3 days ago, not yet settled
        if ($oliviaAppointment) {
            Invoice::updateOrCreate(
                ['appointment_id' => $oliviaAppointment->id],
                [
                    'invoice_number' => 'INV-OLIVIA001',
                    'patient_id'     => $olivia->id,
                    'handled_by'     => $receptionist->id,
                    'total_amount'   => 85.00,
                    'paid_amount'    => 0.00,
                    'payment_method' => null,
                    'payment_status' => 'unpaid',
                    'issued_at'      => Carbon::today()->subDays(3)->setTime(11, 30),
                ]
            );
            // No Payment record — nothing collected yet
        }
    }
}
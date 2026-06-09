<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $invoices = Invoice::with('patient')->latest()->paginate(15);
        return view('billing.index', compact('invoices'));
    }

    // Show one invoice + its payment history
    public function show($id)
    {
        $invoice = Invoice::with(['patient', 'payments'])->findOrFail($id);
        return view('billing.show', compact('invoice'));
    }

    // Auto-generate an invoice — NiB will call this from her AppointmentController
    public function generateInvoice($appointmentId, $patientId, $amount)
    {
        return Invoice::create([
            'appointment_id' => $appointmentId,
            'patient_id'     => $patientId,
            'total_amount'   => $amount,
            'status'         => 'unpaid',
        ]);
    }

    // Record a payment and recalculate the invoice status
    public function recordPayment(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        Payment::create([
            'invoice_id'     => $invoice->id,
            'amount_paid'    => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'paid_at'        => now(),
        ]);

        $totalPaid = $invoice->payments()->sum('amount_paid');

        if ($totalPaid >= $invoice->total_amount) {
            $invoice->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $invoice->update(['status' => 'partial']);
        }

        return redirect()->route('invoices.show', $invoice->id)
                        ->with('success', 'Payment recorded successfully.');
    }
}
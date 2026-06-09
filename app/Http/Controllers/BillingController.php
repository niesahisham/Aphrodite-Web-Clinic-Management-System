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

    public function generateInvoice($appointmentId, $patientId, $amount)
    {
        return Invoice::create([
            'invoice_number' => 'INV-' . str_pad(Invoice::count() + 1, 6, '0', STR_PAD_LEFT),
            'appointment_id' => $appointmentId,
            'patient_id'     => $patientId,
            'total_amount'   => $amount,
            'payment_status' => 'unpaid',
        ]);
    }

    // Record a payment and recalculate the invoice status
    public function recordPayment(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $request->validate([
            'amount_paid'    => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,card,online',
        ]);

        Payment::create([
            'invoice_id'     => $invoice->id,
            'amount_paid'    => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'paid_at'        => now(),
        ]);

        $totalPaid = $invoice->payments()->sum('amount_paid');

        $invoice->update([
            'paid_amount'    => $totalPaid,
            'payment_status' => $totalPaid >= $invoice->total_amount ? 'paid'
                            : ($totalPaid > 0 ? 'partial' : 'unpaid'),
        ]);

        return redirect()->route('invoices.show', $invoice->id)
                        ->with('success', 'Payment recorded successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Appointment;

class BillingController extends Controller
{
    // List all invoices
    public function index()
    {
        $invoices = Invoice::with('patient')->latest()->paginate(15);
        return view('billing.index', compact('invoices'));
    }

    // Show form to manually generate an invoice
    public function create()
    {
        // Only show completed appointments that don't already have an invoice
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'completed')
            ->whereDoesntHave('invoice')
            ->latest('scheduled_at')
            ->get();

        return view('billing.create', compact('appointments'));
    }

    // Save the manually generated invoice
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'total_amount'   => 'required|numeric|min:0.01',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        // Prevent duplicate invoices
        $exists = Invoice::where('appointment_id', $appointment->id)->exists();
        if ($exists) {
            return back()->withErrors(['appointment_id' => 'An invoice already exists for this appointment.']);
        }

        Invoice::create([
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'appointment_id' => $appointment->id,
            'patient_id'     => $appointment->patient_id,
            'total_amount'   => $request->total_amount,
            'paid_amount'    => 0,
            'payment_status' => 'unpaid',
            'handled_by'     => auth()->id(),
            'issued_at'      => now(),
        ]);

        return redirect()->route('invoices.index')
                         ->with('success', 'Invoice generated successfully!');
    }

    // Show one invoice + payment history
    public function show($id)
    {
        $invoice = Invoice::with(['patient', 'payments'])->findOrFail($id);
        return view('billing.show', compact('invoice'));
    }

    // Called internally by QueueController (no route needed)
    public function generateInvoice($appointmentId, $patientId, $amount)
    {
        $exists = Invoice::where('appointment_id', $appointmentId)->exists();
        if ($exists) return;

        return Invoice::create([
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'appointment_id' => $appointmentId,
            'patient_id'     => $patientId,
            'total_amount'   => $amount,
            'paid_amount'    => 0,
            'payment_status' => 'unpaid',
            'handled_by'     => auth()->id(),
            'issued_at'      => now(),
        ]);
    }

    // Record a payment and recalculate invoice status
    public function recordPayment(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $request->validate([
            'amount_paid'    => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,card,online',
        ]);

        $balance = $invoice->total_amount - $invoice->paid_amount;

        if ($request->amount_paid > $balance) {
            return back()->withErrors(['amount_paid' => 'Amount exceeds remaining balance of RM ' . number_format($balance, 2)]);
        }

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
                         ->with('success', 'Payment of RM ' . number_format($request->amount_paid, 2) . ' recorded successfully.');
    }
}
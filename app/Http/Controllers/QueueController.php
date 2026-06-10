<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    // Show today's queue management page
    public function index(Request $request)
    {
        $date = $request->query('date', today()->toDateString());

        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('scheduled_at', $date)
            ->where(function ($query) {
                $query->whereNotNull('queue_no')
                    ->orWhere('status', 'confirmed');
            })
            ->orderByRaw('queue_no IS NULL, queue_no ASC')
            ->orderBy('scheduled_at')
            ->get();

        return view('queue.index', compact('appointments', 'date'));
    }

    // Add confirmed appointment into queue
    public function checkIn(Appointment $appointment)
    {
        if (!$appointment->queue_no) {
            $lastQueueNo = Appointment::whereDate('scheduled_at', $appointment->scheduled_at->toDateString())
                ->whereNotNull('queue_no')
                ->max('queue_no');

            $appointment->update([
                'status' => 'waiting',
                'queue_no' => $lastQueueNo ? $lastQueueNo + 1 : 1,
                'queue_status' => 'waiting',
                'checked_in_at' => now(),
            ]);
        }

        return redirect()->route('queue.index')->with('success', 'Patient added to queue successfully!');
    }

    // Call next patient
    public function call(Appointment $appointment)
    {
        $appointment->update([
            'queue_status' => 'called',
            'called_at' => now(),
        ]);

        return redirect()->route('queue.index')->with('success', 'Patient called successfully!');
    }

    // Mark consultation completed
    public function complete(Appointment $appointment)
    {
        $appointment->update([
            'status'       => 'completed',
            'queue_status' => 'completed',
            'completed_at' => now(),
        ]);

        // Auto-generate invoice if one doesn't exist
        $exists = Invoice::where('appointment_id', $appointment->id)->exists();
        if (!$exists) {
            app(BillingController::class)->generateInvoice(
                $appointment->id,
                $appointment->patient_id,
                100.00 // default or configurable amount
            );
        }

        return redirect()->route('queue.index')->with('success', 'Queue completed successfully!');
    }

    // Cancel queue
    public function cancel(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'cancelled',
            'queue_status' => 'cancelled',
        ]);

        return redirect()->route('queue.index')->with('success', 'Queue cancelled successfully!');
    }

    // Queue display board page
    public function display()
    {
        return view('queue.display');
    }

    // Queue board data for auto refresh
    public function boardData()
    {
        $queue = Appointment::with(['patient', 'doctor'])
            ->whereDate('scheduled_at', today())
            ->whereNotNull('queue_no')
            ->whereIn('queue_status', ['waiting', 'called'])
            ->orderBy('queue_no')
            ->get()
            ->map(function ($appointment) {
                return [
                    'queue_no' => str_pad($appointment->queue_no, 3, '0', STR_PAD_LEFT),
                    'patient_name' => $appointment->patient->full_name,
                    'doctor_name' => $appointment->doctor->name,
                    'appointment_type' => $appointment->appointment_type,
                    'scheduled_time' => $appointment->scheduled_at->format('h:i A'),
                    'queue_status' => ucfirst($appointment->queue_status),
                ];
            });

        return response()->json($queue);
    }
}
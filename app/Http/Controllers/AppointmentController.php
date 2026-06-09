<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Show all appointments
    public function index(Request $request)
    {
        $search = $request->query('search');
        $date = $request->query('date', today()->toDateString());
        $status = $request->query('status');

        $appointments = Appointment::with(['patient', 'doctor', 'bookedBy'])
            ->when($search, function ($query, $search) {
                $query->whereHas('patient', function ($patientQuery) use ($search) {
                    $patientQuery->where('full_name', 'like', "%{$search}%")
                        ->orWhere('patient_code', 'like', "%{$search}%");
                })->orWhereHas('doctor', function ($doctorQuery) use ($search) {
                    $doctorQuery->where('name', 'like', "%{$search}%");
                });
            })
            ->when($date, function ($query, $date) {
                $query->whereDate('scheduled_at', $date);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('scheduled_at')
            ->get();

        return view('appointments.index', compact('appointments', 'search', 'date', 'status'));
    }

    // Show form to create new appointment
    public function create()
    {
        $patients = Patient::where('status', 'Active')->orderBy('full_name')->get();
        $doctors = User::where('role', 'doctor')->orderBy('name')->get();

        return view('appointments.create', compact('patients', 'doctors'));
    }

    // Save new appointment to database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_type' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after_or_equal:today',
            'status' => 'required|in:confirmed,waiting,completed,cancelled',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($this->doctorIsBooked($request->doctor_id, $request->scheduled_at)) {
            return back()->withInput()->withErrors([
                'scheduled_at' => 'This doctor is not available at the selected time. Please choose another slot.',
            ]);
        }

        $appointment = Appointment::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'booked_by' => Auth::id(),
            'appointment_type' => $validated['appointment_type'],
            'scheduled_at' => $validated['scheduled_at'],
            'status' => $validated['status'],
            'reason' => $validated['reason'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($appointment->status === 'waiting') {
            $this->addToQueue($appointment);
        }

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
    }

    // Show single appointment
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'bookedBy']);
        return view('appointments.show', compact('appointment'));
    }

    // Show form to edit appointment
    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('status', 'Active')->orderBy('full_name')->get();
        $doctors = User::where('role', 'doctor')->orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    // Update appointment in database
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_type' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'status' => 'required|in:confirmed,waiting,completed,cancelled',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($this->doctorIsBooked($request->doctor_id, $request->scheduled_at, $appointment->id)) {
            return back()->withInput()->withErrors([
                'scheduled_at' => 'This doctor is not available at the selected time. Please choose another slot.',
            ]);
        }

        $appointment->update($validated);

        if ($appointment->status === 'waiting' && !$appointment->queue_no) {
            $this->addToQueue($appointment);
        }

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully!');
    }

    // Cancel appointment
    public function cancel(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'cancelled',
            'queue_status' => $appointment->queue_no ? 'cancelled' : null,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled successfully!');
    }

    // Delete appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully!');
    }

    // Daily calendar view
    public function daily(Request $request)
    {
        $date = $request->query('date', today()->toDateString());

        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('scheduled_at', $date)
            ->orderBy('scheduled_at')
            ->get();

        return view('appointments.daily', compact('appointments', 'date'));
    }

    // Weekly calendar view
    public function weekly(Request $request)
    {
        $startDate = Carbon::parse($request->query('week', today()->toDateString()))->startOfWeek();
        $endDate = $startDate->copy()->endOfWeek();

        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereBetween('scheduled_at', [$startDate, $endDate])
            ->orderBy('scheduled_at')
            ->get()
            ->groupBy(function ($appointment) {
                return $appointment->scheduled_at->format('Y-m-d');
            });

        return view('appointments.weekly', compact('appointments', 'startDate', 'endDate'));
    }

    // Doctor availability checker for create/edit pages
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        $isBooked = $this->doctorIsBooked(
            $request->doctor_id,
            $request->scheduled_at,
            $request->appointment_id
        );

        return response()->json([
            'available' => !$isBooked,
            'message' => $isBooked
                ? 'Doctor is already booked for this time.'
                : 'Doctor is available for this time.',
        ]);
    }

    // Check if doctor already has an appointment in the same 30-minute slot
    private function doctorIsBooked($doctorId, $scheduledAt, $ignoreAppointmentId = null)
    {
        $selectedTime = Carbon::parse($scheduledAt)->startOfMinute();
        $startTime = $selectedTime->copy()->subMinutes(29);
        $endTime = $selectedTime->copy()->addMinutes(29)->endOfMinute();

        return Appointment::where('doctor_id', $doctorId)
            ->whereBetween('scheduled_at', [$startTime, $endTime])
            ->whereNotIn('status', ['cancelled'])
            ->when($ignoreAppointmentId, function ($query, $ignoreAppointmentId) {
                $query->where('id', '!=', $ignoreAppointmentId);
            })
            ->exists();
    }

    // Auto-generate queue number and add patient to queue
    private function addToQueue(Appointment $appointment)
    {
        $lastQueueNo = Appointment::whereDate('scheduled_at', $appointment->scheduled_at->toDateString())
            ->whereNotNull('queue_no')
            ->max('queue_no');

        $appointment->update([
            'queue_no' => $lastQueueNo ? $lastQueueNo + 1 : 1,
            'queue_status' => 'waiting',
            'checked_in_at' => now(),
        ]);
    }
}
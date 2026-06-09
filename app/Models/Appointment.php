<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'booked_by',
        'appointment_type',
        'scheduled_at',
        'status',
        'reason',
        'notes',
        'queue_no',
        'queue_status',
        'checked_in_at',
        'called_at',
        'completed_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'called_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Appointment belongs to patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Appointment belongs to doctor
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Appointment booked by staff
    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }
}
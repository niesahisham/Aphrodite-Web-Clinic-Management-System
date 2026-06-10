<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'diagnosis',
        'symptoms',
        'treatment_notes',
        'visit_date',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
    ];

    // Medical record belongs to patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Medical record belongs to doctor
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Medical record belongs to appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
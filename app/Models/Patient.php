<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'patient_code',
        'full_name',
        'dob',
        'gender',
        'phone',
        'address',
        'blood_type',
        'allergies',
        'status',
        'registered_by',
    ];

    // Patient belongs to a user (who registered them)
    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    // Patient has many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Patient has many medical records
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    // Patient has many prescriptions
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    // Patient has many invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}

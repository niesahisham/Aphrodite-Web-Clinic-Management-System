<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\QueueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/invoices', [BillingController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{id}', [BillingController::class, 'show'])->name('invoices.show');
    Route::post('/invoices/{id}/pay', [BillingController::class, 'recordPayment'])->name('invoices.pay');
    Route::resource('patients', PatientController::class);
});


// Admin & Authorized Staff Only - User Management & Pharmacy
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
    
});

// Prescriptions — accessible by admin, doctor, nurse
Route::middleware(['auth', 'role:admin,doctor,nurse'])->group(function () {
    Route::resource('prescriptions', PrescriptionController::class);
});

// Drugs — accessible by admin and doctor
Route::middleware(['auth', 'role:admin,doctor'])->group(function () {
    Route::resource('drugs', DrugController::class);
});

// Appointment & Queue module
Route::middleware('auth')->group(function () { 
    Route::get('appointments/daily/calendar', [AppointmentController::class, 'daily'])->name('appointments.daily');
    Route::get('appointments/weekly/calendar', [AppointmentController::class, 'weekly'])->name('appointments.weekly');
    Route::get('appointments/check/availability', [AppointmentController::class, 'checkAvailability'])->name('appointments.availability');
    Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::resource('appointments', AppointmentController::class);

    Route::get('queue', [QueueController::class, 'index'])->name('queue.index');
    Route::patch('queue/{appointment}/check-in', [QueueController::class, 'checkIn'])->name('queue.check-in');
    Route::patch('queue/{appointment}/call', [QueueController::class, 'call'])->name('queue.call');
    Route::patch('queue/{appointment}/complete', [QueueController::class, 'complete'])->name('queue.complete');
    Route::patch('queue/{appointment}/cancel', [QueueController::class, 'cancel'])->name('queue.cancel');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('queue-display', [QueueController::class, 'display'])->name('queue.display');
    Route::get('queue-display/data', [QueueController::class, 'boardData'])->name('queue.board-data');
});

require __DIR__.'/auth.php';
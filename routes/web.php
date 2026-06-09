<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/invoices', BillingController::class);
    Route::post('/invoices/{id}/pay', [BillingController::class, 'recordPayment'])->name('invoices.pay');

    Route::resource('patients', PatientController::class);
});


// Admin only - User Management
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
});

// Admin & Authorized Staff Only - User Management & Pharmacy
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
    
    // Secured Pharmacy Modules
    Route::resource('drugs', DrugController::class);
    Route::resource('prescriptions', PrescriptionController::class);
});

require __DIR__.'/auth.php';
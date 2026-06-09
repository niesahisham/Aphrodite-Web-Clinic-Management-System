<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;


class DashboardController extends Controller
{
    
    public function index()
    {
        $totalPatients     = Patient::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $unpaidInvoices    = Invoice::where('status', 'unpaid')->count();
        // Ask NuA what her Prescription model's status field is called, then add:
        // $pendingPrescriptions = Prescription::where('status', 'pending')->count();

        return view('dashboard.index', compact(
            'totalPatients',
            'todayAppointments',
            'unpaidInvoices'
        ));
    }
}

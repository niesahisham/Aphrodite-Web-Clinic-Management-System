<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\AuditLog;

class DashboardController extends Controller
{
    
    public function index()
    {
        $totalPatients     = Patient::count();
        $todayAppointments = Appointment::whereDate('scheduled_at', today())->count();
        $unpaidInvoices    = Invoice::where('payment_status', 'unpaid')->count();
        $recentActivity = AuditLog::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalPatients',
            'todayAppointments',
            'unpaidInvoices',
            'recentActivity'
        ));
    }
}

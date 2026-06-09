@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <h4 class="mb-4">Dashboard</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <p class="text-muted mb-1 small">Total Patients</p>
                <h3 class="fw-semibold mb-0">{{ $totalPatients }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <p class="text-muted mb-1 small">Today's Appointments</p>
                <h3 class="fw-semibold mb-0">{{ $todayAppointments }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <p class="text-muted mb-1 small">Unpaid Invoices</p>
                <h3 class="fw-semibold mb-0 text-danger">{{ $unpaidInvoices }}</h3>
            </div>
        </div>
    </div>

    <div class="card p-3">
        <h6 class="mb-3">Recent Activity</h6>
        {{-- Placeholder until NAF's audit_logs table is confirmed --}}
        <p class="text-muted small mb-0">Activity feed will appear here once connected to audit_logs.</p>
    </div>
</div>
@endsection
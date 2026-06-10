@extends('layouts.app')

@section('title', 'Dashboard - MediCare')
@section('page-title', 'Dashboard Overview')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5 text-center">
        <p class="text-gray-500 text-sm">Total Patients</p>
        <h3 class="text-3xl font-bold text-gray-800">{{ $totalPatients }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow p-5 text-center">
        <p class="text-gray-500 text-sm">Today's Appointments</p>
        <h3 class="text-3xl font-bold text-gray-800">{{ $todayAppointments }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow p-5 text-center">
        <p class="text-gray-500 text-sm">Unpaid Invoices</p>
        <h3 class="text-3xl font-bold text-red-600">{{ $unpaidInvoices }}</h3>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h6 class="text-sm font-semibold text-gray-700 mb-4">Recent Activity</h6>
    @forelse($recentActivity as $log)
        <div class="flex justify-between text-sm border-b border-gray-100 py-2">
            <span class="text-gray-700">{{ $log->description }}</span>
            <span class="text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
        </div>
    @empty
        <p class="text-gray-400 text-sm">No activity yet.</p>
    @endforelse
</div>

@endsection
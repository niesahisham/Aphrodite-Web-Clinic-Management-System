@extends('layouts.app')

@section('title', 'User & Security - MediCare')
@section('page-title', 'User & Security')

@section('content')

<div class="grid grid-cols-4 gap-4 mb-6">
    <!-- Total Users -->
    <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">Total Users</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
        </div>
        <div class="bg-blue-100 p-3 rounded-xl">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-5-4m0 6H2v-2a4 4 0 015-4m5 6v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75M6 3.13a4 4 0 000 7.75"/>
            </svg>
        </div>
    </div>

    <!-- Doctors -->
    <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">Doctors</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalDoctors }}</p>
        </div>
        <div class="bg-green-100 p-3 rounded-xl">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.88 6.196M15 11h.01M9 11h.01M12 14a3 3 0 006 0"/>
            </svg>
        </div>
    </div>

    <!-- Nurses -->
    <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">Nurses</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalNurses }}</p>
        </div>
        <div class="bg-purple-100 p-3 rounded-xl">
            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </div>
    </div>

    <!-- Security Events -->
    <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">Security Events</p>
            <p class="text-3xl font-bold text-gray-800">{{ $securityEvents }}</p>
        </div>
        <div class="bg-red-100 p-3 rounded-xl">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
    </div>
</div>

<div class="flex gap-6">

    <!-- Left: User Directory -->
    <div class="flex-1">
        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">User Directory</h2>
                <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Add New User</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-3">
                @foreach($users as $user)
                <div class="flex items-center justify-between border border-gray-100 rounded-xl p-4 hover:bg-gray-50">
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="font-medium text-gray-800">{{ $user->name }}</p>
                            @if($user->role == 'admin')
                                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">Admin</span>
                            @elseif($user->role == 'doctor')
                                <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">Doctor</span>
                            @elseif($user->role == 'nurse')
                                <span class="bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">Nurse</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">Receptionist</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('users.edit', $user->id) }}" class="border border-gray-300 text-gray-600 px-3 py-1 rounded-lg text-sm hover:bg-gray-100">✏️ Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border border-red-300 text-red-600 px-3 py-1 rounded-lg text-sm hover:bg-red-50" onclick="return confirm('Delete this user?')">🗑️ Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    <!-- Right: Role Permissions -->
    <div class="w-72">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <h2 class="text-lg font-semibold text-gray-800">Role Permissions</h2>
            </div>

            <div class="mb-4">
                <p class="font-semibold text-gray-700 mb-2">Admin</p>
                <ul class="text-sm text-gray-500 space-y-1 ml-2">
                    <li>• Overview</li>
                    <li>• Patient Management</li>
                    <li>• Appointments</li>
                    <li>• Prescriptions</li>
                    <li>• Billing & Payments</li>
                    <li>• User & Security</li>
                </ul>
            </div>

            <div class="mb-4">
                <p class="font-semibold text-gray-700 mb-2">Doctor</p>
                <ul class="text-sm text-gray-500 space-y-1 ml-2">
                    <li>• Overview</li>
                    <li>• Patient Management</li>
                    <li>• Appointments</li>
                    <li>• Prescriptions</li>
                </ul>
            </div>

            <div class="mb-4">
                <p class="font-semibold text-gray-700 mb-2">Nurse</p>
                <ul class="text-sm text-gray-500 space-y-1 ml-2">
                    <li>• Overview</li>
                    <li>• Patient Management</li>
                    <li>• Appointments</li>
                </ul>
            </div>

            <div>
                <p class="font-semibold text-gray-700 mb-2">Receptionist</p>
                <ul class="text-sm text-gray-500 space-y-1 ml-2">
                    <li>• Overview</li>
                    <li>• Appointments</li>
                    <li>• Billing & Payments</li>
                </ul>
            </div>

        </div>
    </div>

</div>

@endsection
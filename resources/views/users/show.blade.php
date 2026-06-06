@extends('layouts.app')

@section('title', 'User Details - MediCare')
@section('page-title', 'User Details')

@section('content')

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">

        <div class="mb-4">
            <label class="block text-gray-500 text-sm">Name</label>
            <p class="text-gray-800 text-lg font-medium">{{ $user->name }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-500 text-sm">Email</label>
            <p class="text-gray-800 text-lg">{{ $user->email }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-500 text-sm">Role</label>
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm">{{ $user->role }}</span>
        </div>

        <div class="mb-6">
            <label class="block text-gray-500 text-sm">Registered At</label>
            <p class="text-gray-800">{{ $user->created_at->format('d M Y') }}</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('users.edit', $user->id) }}" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                Edit
            </a>
            <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                Back to Users
            </a>
        </div>

    </div>

@endsection
@extends('layouts.app')

@section('title', 'User Management - MediCare')
@section('page-title', 'User Management')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-4 inline-block hover:bg-blue-700">
        + Add New User
    </a>

    <table class="w-full mt-4 border-collapse border border-gray-300 bg-white rounded-lg">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 p-3 text-left">Name</th>
                <th class="border border-gray-300 p-3 text-left">Email</th>
                <th class="border border-gray-300 p-3 text-left">Role</th>
                <th class="border border-gray-300 p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 p-3">{{ $user->name }}</td>
                <td class="border border-gray-300 p-3">{{ $user->email }}</td>
                <td class="border border-gray-300 p-3">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm">{{ $user->role }}</span>
                </td>
                <td class="border border-gray-300 p-3">
                    <a href="{{ route('users.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
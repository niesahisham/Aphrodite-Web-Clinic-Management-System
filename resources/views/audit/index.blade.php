@extends('layouts.app')

@section('title', 'Audit Logs - MediCare')
@section('page-title', 'Audit Logs')

@section('content')

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 p-3 text-left">Date & Time</th>
                    <th class="border border-gray-300 p-3 text-left">User</th>
                    <th class="border border-gray-300 p-3 text-left">Action</th>
                    <th class="border border-gray-300 p-3 text-left">Module</th>
                    <th class="border border-gray-300 p-3 text-left">Description</th>
                    <th class="border border-gray-300 p-3 text-left">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3 text-sm">
                        {{ $log->created_at->format('d M Y, h:i A') }}
                    </td>
                    <td class="border border-gray-300 p-3 text-sm">
                        {{ $log->user_name ?? 'Unknown' }}
                    </td>
                    <td class="border border-gray-300 p-3 text-sm">
                        @if($log->action == 'login')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">login</span>
                        @elseif($log->action == 'logout')
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">logout</span>
                        @else
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">{{ $log->action }}</span>
                        @endif
                    </td>
                    <td class="border border-gray-300 p-3 text-sm">{{ $log->module }}</td>
                    <td class="border border-gray-300 p-3 text-sm">{{ $log->description }}</td>
                    <td class="border border-gray-300 p-3 text-sm">{{ $log->ip_address }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border border-gray-300 p-4 text-center text-gray-500">
                        No logs yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="p-4">
            {{ $logs->links() }}
        </div>
    </div>

@endsection
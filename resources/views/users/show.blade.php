<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-4">
                    <label class="block text-gray-500 text-sm">Name</label>
                    <p class="text-gray-800 text-lg">{{ $user->name }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-500 text-sm">Email</label>
                    <p class="text-gray-800 text-lg">{{ $user->email }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-500 text-sm">Role</label>
                    <p class="text-gray-800 text-lg">{{ $user->role }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-500 text-sm">Registered At</label>
                    <p class="text-gray-800 text-lg">{{ $user->created_at->format('d M Y') }}</p>
                </div>

                <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Users</a>

            </div>
        </div>
    </div>
</x-app-layout>
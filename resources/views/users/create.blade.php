<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Role</label>
                        <select name="role" class="w-full border border-gray-300 rounded p-2" required>
                            <option value="">-- Select Role --</option>
                            <option value="admin">Admin</option>
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Nurse</option>
                            <option value="receptionist">Receptionist</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create User</button>
                    <a href="{{ route('users.index') }}" class="ml-2 text-gray-600">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
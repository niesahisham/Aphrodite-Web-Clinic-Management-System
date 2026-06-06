<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
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

                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Role</label>
                        <select name="role" class="w-full border border-gray-300 rounded p-2" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="doctor" {{ $user->role == 'doctor' ? 'selected' : '' }}>Doctor</option>
                            <option value="nurse" {{ $user->role == 'nurse' ? 'selected' : '' }}>Nurse</option>
                            <option value="receptionist" {{ $user->role == 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update User</button>
                    <a href="{{ route('users.index') }}" class="ml-2 text-gray-600">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
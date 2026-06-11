<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center" style="background-color: #f0f4f8;">

    <div class="bg-white rounded-2xl shadow-lg p-10 w-full max-w-md">

        <!-- Logo & Title -->
        <div class="flex flex-col items-center mb-8">
            <div class="bg-blue-600 rounded-full p-4 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Clinic Management System</h1>
            <p class="text-gray-500 text-sm mt-1">Hospital Management Platform</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <form id="login-form" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    placeholder="Enter your email"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required autofocus>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-1">Password</label>
                <input id="password" type="password" name="password"
                    placeholder="Enter password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Sign In Button -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                Sign In
            </button>

        </form>

        <!-- Divider -->
        <div class="flex items-center my-6">
            <hr class="flex-grow border-gray-200">
            <span class="px-3 text-gray-400 text-sm">Quick Access Demo</span>
            <hr class="flex-grow border-gray-200">
        </div>

        <!-- Role Buttons -->
        <div class="grid grid-cols-2 gap-3">
            <button type="button" onclick="quickLogin('admin@test.com')"
                class="border border-gray-300 rounded-lg py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50">Admin</button>
            <button type="button" onclick="quickLogin('doctor@test.com')"
                class="border border-gray-300 rounded-lg py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50">Doctor</button>
            <button type="button" onclick="quickLogin('nurse@test.com')"
                class="border border-gray-300 rounded-lg py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50">Nurse</button>
            <button type="button" onclick="quickLogin('receptionist@test.com')"
                class="border border-gray-300 rounded-lg py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50">Receptionist</button>
        </div>

    </div>

    <script>
    function quickLogin(email) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password123';
        document.getElementById('login-form').submit();
    }
    </script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Admin Login</title>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
@include('sweetalert::alert')
    <div class="min-h-screen flex flex-col items-center justify-center px-4">

        <!-- Logo -->
        <div class="mb-8 text-center">
            <div class="flex items-center justify-center mb-2">
                <div class="bg-blue-600 text-white text-2xl font-bold w-12 h-12 flex items-center justify-center rounded-xl shadow">
                    T
                </div>
            </div>
            <h1 class="text-2xl font-semibold text-gray-700">Tracking Admin</h1>
            <p class="text-gray-500 text-sm">Monitor & manage tracking system</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white w-full max-w-md shadow-lg rounded-xl p-6">

            <h2 class="text-xl font-semibold text-gray-700 mb-6 text-center">
                Sign in to your account
            </h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm mb-1">Email</label>
                    <input type="email"
                           name="email"
                           required
                           value="{{ old('email') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                           placeholder="admin@example.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm mb-1">Password</label>
                    <input type="password"
                           name="password"
                           required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password') border-red-500 @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me + Forgot -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" class="mr-2">
                        Remember me
                    </label>

                    <a href="#" class="text-sm text-blue-600 hover:underline">
                        Forgot password?
                    </a>
                </div>

                <!-- Login Button -->
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg text-center font-semibold hover:bg-blue-700 transition">
                    Login
                </button>
            </form>

        </div>

        <!-- Footer -->
        <p class="mt-6 text-xs text-gray-500">
            © {{date('Y')}} Tracking System — Admin Panel
        </p>
    </div>

</body>
</html>

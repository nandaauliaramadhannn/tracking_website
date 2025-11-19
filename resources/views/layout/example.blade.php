@extends('layout.app')

@section('title', 'Example Page')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            This is an example page using the modern responsive layout.
        </p>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-center w-12 h-12 rounded-md bg-indigo-500 text-white mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Fast Performance</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Optimized for speed and efficiency with modern web technologies.
            </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-center w-12 h-12 rounded-md bg-green-500 text-white mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Mobile Friendly</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Fully responsive design that works perfectly on all devices.
            </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-center w-12 h-12 rounded-md bg-blue-500 text-white mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Secure</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Built with security best practices and modern authentication.
            </p>
        </div>
    </div>

    <!-- Additional Content Section -->
    <div class="mt-12 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 md:p-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Features</h2>
        <div class="space-y-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Responsive Design</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                        The layout adapts seamlessly to all screen sizes from mobile phones to large desktop displays.
                    </p>
                </div>
            </div>
            <div class="flex items-start">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Modern UI</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                        Clean and modern interface built with Tailwind CSS for a professional look and feel.
                    </p>
                </div>
            </div>
            <div class="flex items-start">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">User-Friendly Navigation</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                        Intuitive navigation with mobile-friendly hamburger menu and user dropdown.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


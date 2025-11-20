<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out transform -translate-x-full dark:bg-gray-800 dark:border-gray-700 lg:translate-x-0 lg:static lg:inset-0">
            <!-- Sidebar Header -->
            <div class="flex justify-between items-center px-6 h-16 border-b border-gray-200 dark:border-gray-700">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button id="sidebar-close"
                        class="text-gray-500 lg:hidden dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="overflow-y-auto flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{route('website.index')}}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('website.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    Website
                </a>

                <a href="{{ route('analytics.index')    }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('analytics.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Analytics
                </a>
                <a href="{{ route('visitor.log.index') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('visitor.log.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Visitor Log
                </a>
                <!-- Divider -->
                {{-- <div class="my-4 border-t border-gray-200 dark:border-gray-700"></div> --}}

                {{-- <a href="#"
                   class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg transition-colors dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Help & Support
                </a> --}}
            </nav>

            <!-- User Section -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex justify-center items-center w-10 h-10 font-medium text-white bg-indigo-500 rounded-full">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1 ml-3 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate dark:text-gray-400">
                            Administrator
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay"
             class="hidden fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex overflow-hidden flex-col flex-1 lg:ml-0">
            <!-- Top Header -->
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between items-center px-4 h-16 sm:px-6 lg:px-8">
                    <!-- Left: Menu Button & Breadcrumb -->
                    <div class="flex items-center">
                        <button id="sidebar-toggle"
                                class="p-2 text-gray-400 rounded-md lg:hidden dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div class="ml-4 lg:ml-0">
                            <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                                @yield('page-title', 'Dashboard')
                            </h1>
                        </div>
                    </div>

                    <!-- Right: Actions & User Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-400 rounded-md dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">View notifications</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="block absolute top-1 right-1 w-2 h-2 bg-red-400 rounded-full ring-2 ring-white dark:ring-gray-800"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="relative" id="admin-user-menu-container">
                            <button type="button"
                                    id="admin-user-menu-button"
                                    class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Open user menu</span>
                                <div class="flex justify-center items-center w-8 h-8 font-medium text-white bg-indigo-500 rounded-full">
                                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                                </div>
                            </button>
                            <div id="admin-user-menu-dropdown"
                                 class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right dark:bg-gray-800 focus:outline-none">
                                <div class="py-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Your Profile
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Settings
                                    </a>
                                    <div class="border-t border-gray-100 dark:border-gray-700"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block px-4 py-2 w-full text-sm text-left text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="overflow-y-auto flex-1 bg-gray-50 dark:bg-gray-900">
                <div class="py-6">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        @if (session('success'))
                            <div class="px-4 py-3 mb-4 text-green-800 bg-green-50 rounded-lg border border-green-200 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="px-4 py-3 mb-4 text-red-800 bg-red-50 rounded-lg border border-red-200 dark:bg-red-900/20 dark:border-red-800 dark:text-red-200">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="px-4 py-3 mb-4 text-red-800 bg-red-50 rounded-lg border border-red-200 dark:bg-red-900/20 dark:border-red-800 dark:text-red-200">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', openSidebar);
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }

        // Admin User Menu Toggle
        const adminUserMenuButton = document.getElementById('admin-user-menu-button');
        const adminUserMenuDropdown = document.getElementById('admin-user-menu-dropdown');

        if (adminUserMenuButton && adminUserMenuDropdown) {
            adminUserMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                adminUserMenuDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const container = document.getElementById('admin-user-menu-container');
                if (container && !container.contains(e.target)) {
                    adminUserMenuDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>


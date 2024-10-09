<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            <aside class="bg-white w-64 hidden sm:block shadow-lg">
                <div class="px-6 py-8">
                    <h2 class="text-xl font-semibold mb-6">FIND X</h2>
                    <nav class="space-y-4">
                        <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md">Dashboard</a>

                        @if(Auth::check()) <!-- Ensure user is logged in to view the menu -->
                            <a href="{{ route('courses.available') }}" class="block text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md">Available Courses</a>
                        @endif

                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
                        <a href="{{ route('enroll.requests') }}" class="block text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md">Enroll Requests</a>
                        @endif

                        <a href="#" class="block text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md">My Courses</a>

                        <a href="#" class="block text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md">Profile</a>
                        <a href="#" class="block text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md">Settings</a>

                        @if(Auth::user()->role == 'admin')

                        <a href="{{ route('admin.users.index') }}" class="block text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md">Users</a>

                        @endif

                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
                            <a href="{{ route('courses.index') }}" class="block text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md">Courses</a>
                        @endif

                    </nav>
                </div>
            </aside>

            <!-- Content Area -->
            <div class="flex-1">
                @livewire('navigation-menu')
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')

        @livewireScripts

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>

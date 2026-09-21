<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bus Ticketing') }}</title>
       <script src="https://cdn.tailwindcss.com"></script>

    {{--    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> Alpine.js via CDN --}}


    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-md sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <!-- Logo / Brand -->
                <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 hover:text-indigo-800 transition">
                    🚍 BusTicketing
                </a>
                
                <!-- Navigation Links (optional) -->
                <nav class="space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">Home</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600">Contact</a>
                      <a href="{{ route('booking.search') }}" class="text-gray-700 hover:text-indigo-600">search</a>
                   
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Dashboard</a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t mt-12">
            <div class="container mx-auto px-4 py-6 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} BusTicketing System. All rights reserved.
            </div>
        </footer>
    </div>
    @livewireScripts
</body>
</html>
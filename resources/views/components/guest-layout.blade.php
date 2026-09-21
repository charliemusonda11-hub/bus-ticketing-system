<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bus Ticketing') }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @livewireStyles
</head>
<body class="antialiased bg-slate-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
            <div class="container mx-auto px-4 h-16 flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-indigo-600 flex items-center gap-2">
                    <span class="text-2xl">🚌</span> BusTicketing
                </a>
                
                <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                    <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Home</a>
                    <a href="{{ route('booking.search') }}" class="hover:text-indigo-600 transition">My Booking</a>
                    <a href="{{ route('schedules.index') }}" class="hover:text-indigo-600 transition">Schedules</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition shadow-sm">Dashboard</a>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <footer class="bg-white border-t py-10">
            <div class="container mx-auto px-4 text-center">
                <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} BusTicketing Zambia. Built for comfort.</p>
            </div>
        </footer>
    </div>
    @livewireScripts
</body>
</html>
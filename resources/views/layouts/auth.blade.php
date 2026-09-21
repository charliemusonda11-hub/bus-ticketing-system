<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bus Ticketing') }} - Auth</title>
   
      <script src="https://cdn.tailwindcss.com"></script>

    {{--    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> Alpine.js via CDN --}}


    @livewireStyles
</head>
<body class="font-sans antialiased bg-gradient-to-br from-indigo-100 to-purple-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo / Brand -->
            <div class="text-center">
                <a href="{{ url('/') }}" class="text-3xl font-bold text-indigo-700">🚍 BusTicketing</a>
                <p class="mt-2 text-gray-600">Admin & Staff Access Only</p>
            </div>
            
            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                 @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
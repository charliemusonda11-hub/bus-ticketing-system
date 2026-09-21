<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    {{--    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> Alpine.js via CDN --}}
<!-- use vite -->


    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-800 text-white flex-shrink-0">
            <div class="p-4 text-2xl font-bold border-b border-indigo-700">AdminPanel</div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-indigo-700">Dashboard</a>
                <a href="{{ route('admin.buses.index') }}" class="block py-2 px-4 hover:bg-indigo-700">Buses</a>
                <a href="{{ route('admin.routes.index') }}" class="block py-2 px-4 hover:bg-indigo-700">Routes</a>
                <a href="{{ route('admin.schedules.index') }}" class="block py-2 px-4 hover:bg-indigo-700">Schedules</a>
                <a href="{{ route('admin.bookings.index') }}" class="block py-2 px-4 hover:bg-indigo-700">Bookings</a>
                                <a href="{{ route('admin.drivers.index') }}" class="block py-2 px-4 hover:bg-indigo-700">Drivers</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 hover:bg-indigo-700">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="bg-white shadow-sm px-6 py-3 flex justify-between items-center">
                <h1 class="text-xl font-semibold">@yield('title')</h1>
                <div>{{ auth()->user()->name }}</div>
            </div>
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
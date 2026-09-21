<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Panel - {{ config('app.name') }}</title>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white flex-shrink-0">
            <div class="p-4 text-2xl font-bold border-b border-blue-700">Driver Panel</div>
            <nav class="mt-6">
                <a href="{{ route('driver.dashboard') }}" class="block py-2 px-4 hover:bg-blue-700">Dashboard</a>
                <a href="{{ route('driver.manifest.index') }}" class="block py-2 px-4 hover:bg-blue-700">My Trips</a>
                <a href="{{ route('driver.validate.form') }}" class="block py-2 px-4 hover:bg-blue-700">Validate Ticket</a>

                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 hover:bg-blue-700">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="bg-white shadow-sm px-6 py-3 flex justify-between items-center">
                <h1 class="text-xl font-semibold">@yield('title')</h1>
                <div>🚌 {{ auth()->user()->name }}</div>
            </div>
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
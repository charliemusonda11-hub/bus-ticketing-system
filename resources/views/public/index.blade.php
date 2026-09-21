<x-guest-layout>
    <div class="relative bg-indigo-900 py-20 md:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80" class="w-full h-full object-cover" alt="Background">
        </div>
        <div class="relative container mx-auto px-4 text-center">
            <span class="inline-block px-4 py-1.5 mb-6 text-xs font-semibold tracking-widest uppercase bg-indigo-500 text-white rounded-full">Fast & Reliable</span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                Your Journey Begins <br><span class="text-indigo-400">Under the Zambian Sun</span>
            </h1>
            <p class="text-indigo-100 text-lg md:text-xl max-w-2xl mx-auto mb-10">
                Instantly book your seat for inter-city travel. Transparent pricing, no hidden fees.
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-12 relative z-10">
        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-200/50 p-2 md:p-4">
            <div class="bg-slate-50 rounded-2xl p-6 md:p-8">
           <form method="GET" action="{{ route('schedules.search') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
    <div>
        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">From</label>
        <div class="relative">
            <select name="origin" required class="w-full bg-white border-0 ring-1 ring-slate-200 rounded-xl py-3 pl-4 focus:ring-2 focus:ring-indigo-500 appearance-none shadow-sm">
                <option value="">Starting Point</option>
                @foreach(\App\Models\Route::select('origin')->distinct()->get() as $route)
                    <option value="{{ $route->origin }}" {{ request('origin') == $route->origin ? 'selected' : '' }}>
                        {{ $route->origin }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">To</label>
        <div class="relative">
            <select name="destination" required class="w-full bg-white border-0 ring-1 ring-slate-200 rounded-xl py-3 pl-4 focus:ring-2 focus:ring-indigo-500 appearance-none shadow-sm">
                <option value="">Destination</option>
                @foreach(\App\Models\Route::select('destination')->distinct()->get() as $route)
                    <option value="{{ $route->destination }}" {{ request('destination') == $route->destination ? 'selected' : '' }}>
                        {{ $route->destination }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div>
        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Travel Date</label>
        <input type="date" name="date" required 
               min="{{ date('Y-m-d') }}" 
               value="{{ request('date', date('Y-m-d')) }}"
               class="w-full bg-white border-0 ring-1 ring-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 shadow-sm">
    </div>

    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl transition duration-300 shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        Find Bus
    </button>
</form>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Available Today</h2>
                <p class="text-slate-500">Quick-book the next available departures.</p>
            </div>
            <a href="{{ route('schedules.index') }}" class="text-indigo-600 font-semibold hover:underline">View all schedules &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                // Fetching top 6 upcoming schedules for today
                $todaySchedules = \App\Models\Schedule::with(['bus', 'route'])
                    ->whereDate('departure_time', '>=', now())
                    ->orderBy('departure_time', 'asc')
                    ->take(6)
                    ->get();
            @endphp

            @forelse($todaySchedules as $schedule)
                <div class="bg-white border border-slate-100 rounded-2xl p-6 hover:shadow-xl transition group">
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">Available</span>
                        <span class="text-2xl font-bold text-indigo-600">K{{ number_format($schedule->price, 2) }}</span>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-2 h-2 rounded-full bg-indigo-400"></div>
                            <span class="text-lg font-bold text-slate-700">{{ $schedule->route->origin }}</span>
                        </div>
                        <div class="w-0.5 h-4 bg-slate-200 ml-0.75 mb-2"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-orange-400"></div>
                            <span class="text-lg font-bold text-slate-700">{{ $schedule->route->destination }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                        <div class="text-sm">
                            <p class="text-slate-400">Departure</p>
                            <p class="font-semibold text-slate-700">{{ $schedule->departure_time->format('H:i A') }}</p>
                        </div>
                        <a href="{{ route('seat.selection', $schedule)}}" 
                           class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-semibold group-hover:bg-indigo-600 transition">
                            Book Seat
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-slate-100 rounded-2xl border-2 border-dashed border-slate-200">
                    <p class="text-slate-500">No scheduled buses found for today. Try searching for a specific date.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-guest-layout>
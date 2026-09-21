<x-guest-layout>
    <div class="bg-white border-b border-slate-100 py-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Available Buses</h1>
                    <div class="flex items-center gap-2 mt-2 text-slate-500 font-medium">
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-xs font-bold uppercase tracking-wider">
                            {{ request('origin', 'Anywhere') }}
                        </span>
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-xs font-bold uppercase tracking-wider">
                            {{ request('destination', 'Anywhere') }}
                        </span>
                        <span class="mx-2 text-slate-300">•</span>
                        <span>{{ \Carbon\Carbon::parse(request('date'))->format('D, M j, Y') }}</span>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Modify Search
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-8">
                @if($schedules->count() > 0)
                    <div class="space-y-6">
                        @foreach($schedules as $schedule)
                            <div class="group bg-white border border-slate-200 rounded-3xl overflow-hidden hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-300">
                                <div class="p-6 md:p-8">
                                    <div class="flex flex-col md:flex-row justify-between gap-6">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-xl group-hover:bg-indigo-50 transition">
                                                🚌
                                            </div>
                                            <div>
                                                <h3 class="font-black text-slate-900 text-lg">{{ $schedule->bus->company_name }}</h3>
                                                <p class="text-sm text-slate-500 font-medium">{{ $schedule->bus->name }} • {{ ucfirst($schedule->bus->type) }}</p>
                                                <div class="mt-2 flex gap-2">
                                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-500 rounded uppercase tracking-widest">AC</span>
                                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-500 rounded uppercase tracking-widest">WiFi</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex flex-row md:flex-col justify-between items-end md:text-right">
                                            <div>
                                                <p class="text-2xl font-black text-slate-900">{{ $schedule->departure_time->format('H:i') }}</p>
                                                <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Departure Time</p>
                                            </div>
                                            <div class="mt-auto">
                                                <p class="text-2xl font-black text-indigo-600">K{{ number_format($schedule->price, 2) }}</p>
                                                <a href="{{ route('seat.selection', $schedule) }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-indigo-600 text-white text-xs font-bold py-3 px-6 rounded-xl mt-3 transition-all duration-300">
                                                    Select Seats
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white border-2 border-dashed border-slate-200 rounded-[3rem] p-16 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl grayscale">
                            🔍
                        </div>
                        <h3 class="text-2xl font-black text-slate-900">No buses found for this route</h3>
                        <p class="text-slate-500 mt-2 max-w-sm mx-auto">We couldn't find any trips for the selected criteria. Try checking the "Recommended Trips" below!</p>
                        <a href="{{ route('home') }}" class="mt-8 inline-block bg-slate-900 text-white font-bold py-4 px-8 rounded-2xl hover:bg-slate-800 transition">
                            Back to Home
                        </a>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-4">
                <div class="sticky top-8 space-y-8">
                    <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/20 blur-3xl rounded-full"></div>
                        
                        <h4 class="text-lg font-bold mb-6 flex items-center gap-2">
                            <span class="text-indigo-400 italic">★</span> Popular Routes
                        </h4>
                        
                        <div class="space-y-4">
                            @foreach(\App\Models\Schedule::with('route')->where('departure_time', '>', now())->take(5)->get() as $pop)
                                <a href="{{ route('schedules.search', ['origin' => $pop->route->origin, 'destination' => $pop->route->destination, 'date' => $pop->departure_time->format('Y-m-d')]) }}" class="block p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition group">
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm font-bold">
                                            {{ $pop->route->origin }} → {{ $pop->route->destination }}
                                        </div>
                                        <div class="text-indigo-400 group-hover:translate-x-1 transition-transform">→</div>
                                    </div>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $pop->departure_time->format('D, M d') }}</span>
                                        <span class="text-xs font-black">K{{ number_format($pop->price, 0) }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white">
                        <h4 class="font-black text-xl mb-2">Travel Better.</h4>
                        <p class="text-indigo-100 text-sm mb-6">Download our mobile app for faster booking and real-time bus tracking.</p>
                        <div class="flex gap-2">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center font-bold text-xs uppercase">iOS</div>
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center font-bold text-xs uppercase">AND</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
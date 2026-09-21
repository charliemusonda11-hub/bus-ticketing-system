<x-guest-layout>
    <div class="bg-white border-b border-slate-100 py-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">All Schedules</h1>
                    <p class="mt-2 text-slate-500">Browse every upcoming bus schedule, sorted by departure time.</p>
                    <div class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-slate-500">
                        <span>{{ $schedules->count() }} schedule{{ $schedules->count() === 1 ? '' : 's' }}</span>
                        <span class="text-slate-300">•</span>
                        <span>Updated {{ now()->format('M j, Y') }}</span>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Back to Home
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
                                                <h3 class="font-black text-slate-900 text-lg">{{ $schedule->bus->company_name ?? 'Unknown Bus' }}</h3>
                                                <p class="text-sm text-slate-500 font-medium">{{ $schedule->bus->name ?? 'Bus' }} • {{ ucfirst($schedule->bus->type ?? 'standard') }}</p>
                                                <p class="mt-2 text-sm text-slate-500">{{ $schedule->route->origin ?? 'Unknown' }} → {{ $schedule->route->destination ?? 'Unknown' }}</p>
                                                <p class="mt-1 text-sm text-slate-400">Route: {{ $schedule->route->name ?? ($schedule->route->origin ?? 'Unknown') . ' to ' . ($schedule->route->destination ?? 'Unknown') }}</p>
                                            </div>
                                        </div>

                                        <div class="flex flex-row md:flex-col justify-between items-end md:text-right">
                                            <div>
                                                <p class="text-2xl font-black text-slate-900">{{ $schedule->departure_time->format('H:i') }}</p>
                                                <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Departure Time</p>
                                            </div>
                                            <div class="mt-auto text-right">
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
                        <h3 class="text-2xl font-black text-slate-900">No schedules available</h3>
                        <p class="text-slate-500 mt-2 max-w-sm mx-auto">There are currently no bus schedules to show. Please check back later or add schedules from the admin panel.</p>
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
                            <span class="text-indigo-400 italic">★</span> Schedule Summary
                        </h4>
                        <div class="space-y-4 text-sm text-slate-200">
                            <div class="flex justify-between items-center border-b border-white/10 pb-3">
                                <span>Total Schedules</span>
                                <span class="font-bold">{{ $schedules->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-white/10 py-3">
                                <span>Next Departure</span>
                                <span class="font-bold">{{ optional($schedules->first())->departure_time?->format('D, M j H:i') ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-3">
                                <span>Most popular route</span>
                                <span class="font-bold">{{ optional($schedules->groupBy('route_id')->sortByDesc(fn($group) => $group->count())->first()?->first()->route)->origin ?? 'N/A' }} → {{ optional($schedules->groupBy('route_id')->sortByDesc(fn($group) => $group->count())->first()?->first()->route)->destination ?? '' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white">
                        <h4 class="font-black text-xl mb-2">Need Help?</h4>
                        <p class="text-indigo-100 text-sm mb-6">Contact support for booking assistance or schedule changes.</p>
                        <a href="mailto:support@example.com" class="inline-flex items-center justify-center w-full rounded-2xl bg-white text-slate-900 font-bold py-3 hover:bg-slate-100 transition">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>


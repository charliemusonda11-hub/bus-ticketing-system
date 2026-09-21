<x-guest-layout>
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Available Buses</h1>
            <p class="text-indigo-100">
                Showing trips for 
                <strong>{{ request()->route_id ? \App\Models\Route::find(request()->route_id)->origin . ' → ' . \App\Models\Route::find(request()->route_id)->destination : 'all routes' }}</strong> 
                on <strong>{{ \Carbon\Carbon::parse(request()->date)->format('F j, Y') }}</strong>
            </p>
        </div>
    </div>

    <!-- Results Container -->
    <div class="container mx-auto px-4 py-8">
        @if($schedules->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schedules as $schedule)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <!-- Bus Company Header -->
                        <div class="bg-gray-800 text-white px-4 py-3">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-lg">{{ $schedule->bus->company_name }}</span>
                                <span class="text-xs bg-indigo-500 px-2 py-1 rounded-full">{{ ucfirst($schedule->bus->type) }}</span>
                            </div>
                        </div>
                        
                        <!-- Card Body -->
                        <div class="p-5">
                            <!-- Bus Name & Plate -->
                            <div class="mb-3">
                                <p class="text-gray-600 text-sm">Bus: <span class="font-semibold">{{ $schedule->bus->name }}</span></p>
                                <p class="text-gray-600 text-sm">Plate: <span class="font-mono">{{ $schedule->bus->plate_number }}</span></p>
                            </div>
                            
                            <!-- Departure Time -->
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-lg font-medium">{{ $schedule->departure_time->format('h:i A') }}</span>
                                <span class="ml-2 text-gray-500 text-sm">{{ $schedule->departure_time->format('d M Y') }}</span>
                            </div>
                            
                            <!-- Price -->
                            <div class="mb-5">
                                <span class="text-2xl font-bold text-indigo-600">K{{ number_format($schedule->price, 2) }}</span>
                                <span class="text-gray-500">per seat</span>
                            </div>
                            
                            <!-- Action Button -->
                            <a href="{{ route('seat.selection', $schedule) }}" 
                               class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                Select Seats →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Results -->
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No buses available</h3>
                <p class="text-gray-500">Please try a different route or date.</p>
                <a href="{{ route('home') }}" class="inline-block mt-4 text-indigo-600 hover:underline">← Back to search</a>
            </div>
        @endif
        
        <!-- Back to Search Link -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800 inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Modify Search
            </a>
        </div>
    </div>
</x-guest-layout>
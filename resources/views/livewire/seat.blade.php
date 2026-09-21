<div x-data="{
    selectedSeats: @entangle('selectedSeats').live,
    seats: @js($this->seats),
    toggleSeat(seatId, isBooked) {
        if (isBooked) return;
        if (this.selectedSeats.includes(seatId)) {
            this.selectedSeats = this.selectedSeats.filter(id => id !== seatId);
        } else {
            this.selectedSeats.push(seatId);
        }
    }
}" class="max-w-5xl mx-auto">
    
    <!-- Header with bus info -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-5 text-white mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">{{ $schedule->bus->company_name }}</h2>
                <p class="text-indigo-100">{{ $schedule->bus->name }} • {{ $schedule->bus->plate_number }}</p>
                <p class="text-sm mt-1">Departure: {{ $schedule->departure_time->format('l, F j, Y \a\t h:i A') }}</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold">K{{ number_format($schedule->price, 2) }}</p>
                <p class="text-sm">per seat</p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Seat Map Column -->
        <div class="lg:col-span-2">
            <div class="bg-gray-100 rounded-xl p-6 shadow-inner">
                <div class="text-center mb-4 text-gray-500 text-sm">
                    <span class="inline-flex items-center mx-2"><span class="w-4 h-4 bg-green-500 rounded inline-block mr-1"></span> Available</span>
                    <span class="inline-flex items-center mx-2"><span class="w-4 h-4 bg-red-500 rounded inline-block mr-1"></span> Booked</span>
                    <span class="inline-flex items-center mx-2"><span class="w-4 h-4 bg-blue-500 rounded inline-block mr-1"></span> Selected</span>
                </div>
                
                <!-- Bus Simulator Layout -->
                <div class="relative">
                    <!-- Driver area (front of bus) -->
                    <div class="bg-gray-300 rounded-t-lg p-2 mb-4 text-center text-gray-700 text-sm font-semibold">
                        🚌 DRIVER
                    </div>
                    
                    <!-- Seat grid – responsive based on seat count -->
                    <div class="grid grid-cols-4 gap-3 justify-items-center">
                        @php
                            // Group seats by row letter (A, B, C...) for better visual
                            $seatsByRow = $this->seats->groupBy(function($seat) {
                                return substr($seat['number'], 0, 1);
                            });
                        @endphp
                        
                        @foreach($seatsByRow as $row => $rowSeats)
                            <div class="col-span-4 flex justify-between items-center mb-2">
                                <div class="text-gray-500 font-bold w-8">{{ $row }}</div>
                                <div class="flex gap-3 flex-1 justify-center">
                                    @foreach($rowSeats as $seat)
                                      <button type="button"
    @click="toggleSeat({{ $seat['id'] }}, @js($seat['is_booked']))"
    :class="{
        'bg-green-500 hover:bg-green-600': !@js($seat['is_booked']) && !selectedSeats.includes({{ $seat['id'] }}),
        'bg-red-500 cursor-not-allowed': @js($seat['is_booked']),
        'bg-blue-500 hover:bg-blue-600': selectedSeats.includes({{ $seat['id'] }})
    }"
    class="w-12 h-12 rounded-lg text-white font-bold transition transform hover:scale-105 focus:outline-none"
    :disabled="@js($seat['is_booked'])">
    {{ $seat['number'] }}
</button>
                                    @endforeach
                                </div>
                                <div class="w-8"></div>
                            </div>
                            <!-- Aisle after each row except last -->
                            @if(!$loop->last)
                                <div class="col-span-4 h-4"></div>
                            @endif
                        @endforeach
                    </div>
                    
                    <!-- Back door area -->
                    <div class="bg-gray-300 rounded-b-lg mt-4 p-2 text-center text-gray-700 text-sm">
                        🚪 EXIT
                    </div>
                </div>
                
                <div class="mt-4 text-sm text-gray-500 text-center">
                    Click on a green seat to select it. Selected seats turn blue.
                </div>
            </div>
        </div>
        
        <!-- Booking Form Column -->
        <div class="lg:col-span-1">
            <form wire:submit.prevent="submitBooking" class="bg-white rounded-xl shadow-lg p-5">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Contact Details</h3>
                <div class="space-y-3">
                    <input type="text" wire:model="contactName" placeholder="Full Name *" 
                        class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                    @error('contactName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    
                    <input type="email" wire:model="contactEmail" placeholder="Email Address *" 
                        class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                    @error('contactEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    
                    <input type="text" wire:model="contactPhone" placeholder="Phone Number *" 
                        class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                    @error('contactPhone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div x-show="selectedSeats.length > 0" x-cloak class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Passenger Details</h3>
                    <div class="space-y-4 max-h-80 overflow-y-auto pr-1">
                     <template x-for="seatId in selectedSeats" :key="seatId">
    <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
        <div class="font-medium text-indigo-600 mb-2">
            Seat <span x-text="seats.find(s => s.id == seatId)?.number"></span>
        </div>

        <input type="text"
            @input="$wire.set('passengerDetails.' + seatId + '.name', $event.target.value)"
            placeholder="Passenger Name *"
            class="w-full border-gray-300 rounded text-sm mb-2">

        <input type="text"
            @input="$wire.set('passengerDetails.' + seatId + '.phone', $event.target.value)"
            placeholder="Phone (optional)"
            class="w-full border-gray-300 rounded text-sm">
    </div>
</template>
                    </div>
                </div>
                
                <div class="mt-6">
                    <div class="flex justify-between text-gray-700 mb-4">
                        <span>Selected seats:</span>
                        <span class="font-bold" x-text="selectedSeats.length"></span>
                    </div>
                    <div class="flex justify-between text-gray-800 font-bold text-lg mb-4">
                        <span>Total:</span>
                        <span>K<span x-text="selectedSeats.length * {{ $schedule->price }}"></span></span>
                    </div>
                    <button type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition duration-200 transform hover:scale-105">
                        Confirm Booking →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
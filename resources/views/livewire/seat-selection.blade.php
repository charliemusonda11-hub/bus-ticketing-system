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
}" class="max-w-6xl mx-auto px-4 py-8">
    
    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-2xl">
                    🚌
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">{{ $schedule->bus->company_name }}</h2>
                    <p class="text-slate-500 font-medium text-sm">{{ $schedule->bus->name }} • {{ $schedule->bus->plate_number }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-8">
                <div class="text-center md:text-left">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Departure</p>
                    <p class="font-bold text-slate-800">{{ $schedule->departure_time->format('D, M d • h:i A') }}</p>
                </div>
                <div class="h-10 w-px bg-slate-200 hidden md:block"></div>
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Price</p>
                    <p class="text-2xl font-black text-indigo-600">K{{ number_format($schedule->price, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7">
            <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
                <div class="flex justify-center gap-6 mb-10 pb-6 border-b border-slate-50 text-xs font-bold uppercase tracking-wider">
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-slate-100 ring-1 ring-slate-200 rounded-md"></span>
                        <span class="text-slate-500">Available</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-indigo-600 rounded-md"></span>
                        <span class="text-slate-500">Selected</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-slate-300 rounded-md"></span>
                        <span class="text-slate-500">Booked</span>
                    </div>
                </div>
                
                <div class="max-w-xs mx-auto border-4 border-slate-100 rounded-[3rem] p-4 relative">
                    <div class="flex justify-between items-center mb-10 px-4">
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-lg grayscale">🛞</div>
                        <div class="px-4 py-1 bg-slate-50 rounded-full text-[10px] font-bold text-slate-400 uppercase tracking-widest">Front of Bus</div>
                    </div>
                    
                    <div class="space-y-4">
                        @php
                            $seatsByRow = $this->seats->groupBy(function($seat) {
                                return substr($seat['number'], 0, 1);
                            });
                        @endphp
                        
                        @foreach($seatsByRow as $row => $rowSeats)
                            <div class="flex justify-between items-center px-2">
                                <div class="flex gap-3">
                                    @foreach($rowSeats->take(2) as $seat)
                                        <button type="button"
                                            @click="toggleSeat({{ $seat['id'] }}, @js($seat['is_booked']))"
                                            :class="{
                                                'bg-slate-50 ring-1 ring-slate-200 text-slate-600 hover:ring-indigo-500': !@js($seat['is_booked']) && !selectedSeats.includes({{ $seat['id'] }}),
                                                'bg-slate-300 text-white cursor-not-allowed': @js($seat['is_booked']),
                                                'bg-indigo-600 text-white ring-2 ring-indigo-200 scale-105 shadow-lg shadow-indigo-100': selectedSeats.includes({{ $seat['id'] }})
                                            }"
                                            class="w-11 h-11 rounded-xl text-xs font-bold transition-all duration-200 focus:outline-none"
                                            :disabled="@js($seat['is_booked'])">
                                            {{ $seat['number'] }}
                                        </button>
                                    @endforeach
                                </div>

                                <div class="w-8 text-[10px] font-bold text-slate-200 text-center">{{ $row }}</div>

                                <div class="flex gap-3">
                                    @foreach($rowSeats->skip(2) as $seat)
                                        <button type="button"
                                            @click="toggleSeat({{ $seat['id'] }}, @js($seat['is_booked']))"
                                            :class="{
                                                'bg-slate-50 ring-1 ring-slate-200 text-slate-600 hover:ring-indigo-500': !@js($seat['is_booked']) && !selectedSeats.includes({{ $seat['id'] }}),
                                                'bg-slate-300 text-white cursor-not-allowed': @js($seat['is_booked']),
                                                'bg-indigo-600 text-white ring-2 ring-indigo-200 scale-105 shadow-lg shadow-indigo-100': selectedSeats.includes({{ $seat['id'] }})
                                            }"
                                            class="w-11 h-11 rounded-xl text-xs font-bold transition-all duration-200 focus:outline-none"
                                            :disabled="@js($seat['is_booked'])">
                                            {{ $seat['number'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-10 py-4 border-t border-slate-50 flex justify-center">
                        <div class="w-20 h-1.5 bg-slate-100 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-5">
            <div class="sticky top-24">
                <form wire:submit.prevent="submitBooking" class="bg-white border border-slate-200 rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden">
                    <div class="p-6 bg-slate-50 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Booking Details</h3>
                        <p class="text-sm text-slate-500">Provide contact and passenger info</p>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Contact Name</label>
                                <input type="text" wire:model="contactName" placeholder="Full Name" 
                                    class="w-full bg-white border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 transition">
                                @error('contactName') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Email</label>
                                    <input type="email" wire:model="contactEmail" placeholder="email@example.com" 
                                        class="w-full bg-white border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 transition">
                                    @error('contactEmail') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Phone</label>
                                    <input type="text" wire:model="contactPhone" placeholder="097..." 
                                        class="w-full bg-white border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 transition">
                                    @error('contactPhone') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div x-show="selectedSeats.length > 0" x-cloak class="mt-8">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Passenger List</h4>
                            <div class="space-y-3 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                                <template x-for="seatId in selectedSeats" :key="seatId">
                                    <div class="p-4 bg-indigo-50/50 border border-indigo-100 rounded-2xl">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-xs font-bold text-indigo-600">SEAT <span x-text="seats.find(s => s.id == seatId)?.number"></span></span>
                                        </div>
                                        <input type="text"
                                            @input="$wire.set('passengerDetails.' + seatId + '.name', $event.target.value)"
                                            placeholder="Passenger Name"
                                            class="w-full bg-white border-slate-200 rounded-lg text-sm mb-2 focus:ring-indigo-500">
                                        <input type="text"
                                            @input="$wire.set('passengerDetails.' + seatId + '.phone', $event.target.value)"
                                            placeholder="Phone Number (Optional)"
                                            class="w-full bg-white border-slate-200 rounded-lg text-sm focus:ring-indigo-500">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-900 text-white">
                        <div class="flex justify-between items-center mb-4 text-slate-400 text-sm">
                            <span>Selected Seats (<span x-text="selectedSeats.length"></span>)</span>
                            <span class="text-white font-bold">K<span x-text="(selectedSeats.length * {{ $schedule->price }}).toLocaleString()"></span></span>
                        </div>
                        <button type="submit" 
                            :disabled="selectedSeats.length === 0"
                            class="w-full bg-indigo-500 hover:bg-indigo-400 disabled:bg-slate-700 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl transition duration-300 flex items-center justify-center gap-2">
                            <span>Confirm & Pay Now</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
<x-guest-layout>
    <div class="py-16 md:py-24 bg-slate-50 min-h-[calc(100vh-160px)]">
        <div class="max-w-xl mx-auto px-4">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900">Manage Your Booking</h2>
                <p class="text-slate-500 mt-2">Enter your reference number to view or download your ticket.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 p-8 border border-slate-100">
                <form method="POST" action="{{ route('booking.search.submit') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="booking_reference" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">
                            Booking Reference
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-400">#</span>
                            </div>
                            <input type="text" 
                                   id="booking_reference"
                                   name="booking_reference"
                                   required
                                   placeholder="BT-XXXX-XXXX" 
                                   class="w-full bg-slate-50 border-0 ring-1 ring-slate-200 rounded-xl py-4 pl-10 pr-4 focus:ring-2 focus:ring-indigo-500 transition shadow-sm placeholder:text-slate-400 font-mono"
                            >
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition duration-300 shadow-lg shadow-indigo-200 flex items-center justify-center gap-2 group">
                        <span>Find My Ticket</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>

                @if(session('error'))
                    <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-xl flex items-center gap-3 text-red-600">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                @endif
            </div>

            <div class="mt-8 text-center">
                <p class="text-sm text-slate-400">
                    Can't find your reference? Check your SMS or email inbox.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
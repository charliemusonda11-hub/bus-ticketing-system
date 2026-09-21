<x-guest-layout>
    @php
        $data = session('booking_data');
    @endphp

    <div class="py-12 md:py-20 bg-slate-50 min-h-[calc(100vh-160px)]">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex items-center justify-center mb-10 space-x-4 text-sm font-bold uppercase tracking-widest">
                <span class="text-slate-400">01 Seats</span>
                <span class="text-slate-300">→</span>
                <span class="text-indigo-600">02 Checkout</span>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
                <div class="p-8 border-b border-dashed border-slate-200 relative">
                    <div class="absolute -bottom-3 -left-3 w-6 h-6 bg-slate-50 rounded-full border border-slate-100 shadow-inner"></div>
                    <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-slate-50 rounded-full border border-slate-100 shadow-inner"></div>
                    
                    <h2 class="text-2xl font-black text-slate-800 mb-6">Booking Summary</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Passenger Contact</label>
                            <p class="font-bold text-slate-800">{{ $data['contact_name'] }}</p>
                            <p class="text-sm text-slate-500">{{ $data['contact_email'] }}</p>
                            <p class="text-sm text-slate-500">{{ $data['contact_phone'] }}</p>
                        </div>
                        <div class="md:text-right">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Selected Seats</label>
                            <div class="flex flex-wrap md:justify-end gap-2 mt-2">
                                @foreach($data['selected_seats'] as $seat)
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold ring-1 ring-indigo-100">
                                        Seat {{ $seat }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-slate-50/50">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Grand Total</p>
                            <p class="text-xs text-slate-400 font-medium">Inclusive of all taxes</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-black text-slate-900">K{{ number_format($data['total_amount'], 2) }}</p>
                        </div>
                    </div>

                    <button id="payBtn"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-5 rounded-2xl transition duration-300 shadow-lg shadow-emerald-200 flex items-center justify-center gap-3 group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 21a8.966 8.966 0 01-5.982-2.275M15 15l1.282 1.282a2 2 0 002.828 0l2.586-2.586a2 2 0 000-2.828l-2.586-2.586a2 2 0 00-2.828 0L15 12"></path>
                        </svg>
                        <span class="text-lg">Secure Payment with Paystack</span>
                    </button>
                    
                    <p class="text-center text-[10px] text-slate-400 mt-6 uppercase tracking-widest font-bold">
                        🔒 Secured by 256-bit SSL encryption
                    </p>
                </div>
            </div>
            
            <div class="mt-8 text-center">
                <a href="{{ url()->previous() }}" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition">
                    ← Change seat selection
                </a>
            </div>
        </div>
    </div>

    <script src="https://js.paystack.co/v2/inline.js"></script>

    <script>
    document.getElementById('payBtn').addEventListener('click', function () {
        // Simple loading state
        const btn = this;
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Processing...';

        fetch("{{ route('booking.payment.initiate') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                amount: {{ $data['total_amount'] }}
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                const popup = new PaystackPop();
                popup.newTransaction({
                    key: data.key,
                    email: "{{ $data['contact_email'] }}",
                    amount: data.amount,
                    reference: data.reference,
                    onSuccess: function(response) {
                        window.location.href = "/booking/callback?reference=" + response.reference;
                    },
                    onCancel: function() {
                        btn.disabled = false;
                        btn.innerHTML = originalContent;
                    }
                });
            } else {
                alert("Failed to initialize payment. Please try again.");
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = originalContent;
        });
    });
    </script>
</x-guest-layout>
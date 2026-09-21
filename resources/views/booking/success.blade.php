<x-guest-layout>
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold text-green-600 text-center">
        🎫 Booking Successful
    </h2>

    <div class="mt-4 text-center">
        <p class="text-gray-600">Reference:</p>
        <p class="text-xl font-bold text-indigo-600">{{ $booking->booking_reference }}</p>
    </div>

    <div class="mt-6">
        <p><strong>Bus:</strong> {{ $booking->schedule->bus->company_name }}</p>
        <p><strong>Route From:</strong> {{ $booking->schedule->route->origin ?? 'N/A' }}</p>
           <p><strong>Destination	:</strong> {{ $booking->schedule->route->destination ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ $booking->schedule->departure_time }}</p>
    </div>

    <div class="mt-6">
        <h3 class="font-bold mb-2">Passengers</h3>

        @foreach($booking->seats as $seat)
            <div class="border p-2 mb-2 rounded">
                Seat: {{ $seat->seat->seat_number }} <br>
                Name: {{ $seat->passenger_name }}
            </div>
        @endforeach
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('booking.download', [$booking->booking_reference]) }}"
           class="bg-indigo-600 text-white px-6 py-2 rounded">
            Download Ticket PDF
        </a>
    </div>
</div>
</x-guest-layout>
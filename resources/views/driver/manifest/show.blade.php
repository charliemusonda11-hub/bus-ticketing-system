@extends('layouts.driver')

@section('title', 'Passenger Manifest - ' . $schedule->bus->name)

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold">{{ $schedule->bus->company_name }} - {{ $schedule->bus->name }}</h2>
        <p>{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</p>
        <p>Departure: {{ $schedule->departure_time->format('l, F j, Y \a\t h:i A') }}</p>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-gray-100 p-3 rounded text-center">
            <div class="text-sm text-gray-600">Total Seats</div>
            <div class="text-2xl font-bold">{{ $stats['total_seats'] }}</div>
        </div>
        <div class="bg-gray-100 p-3 rounded text-center">
            <div class="text-sm text-gray-600">Booked Seats</div>
            <div class="text-2xl font-bold">{{ $stats['booked_seats'] }}</div>
        </div>
        <div class="bg-gray-100 p-3 rounded text-center">
            <div class="text-sm text-gray-600">Checked In</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['checked_in'] }}</div>
        </div>
    </div>

    <h3 class="text-lg font-semibold mb-3">Passenger List</h3>
    @if($passengers->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border">
                <thead>
                    <tr><th>Seat</th><th>Passenger Name</th><th>Phone</th><th>Booking Ref</th><th>Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @foreach($passengers as $p)
                    <tr>
                        <td class="border px-4 py-2">{{ $p['seat_number'] }}</td>
                        <td class="border px-4 py-2">{{ $p['passenger_name'] }}</td>
                        <td class="border px-4 py-2">{{ $p['passenger_phone'] ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $p['booking_reference'] }}</td>
                        <td class="border px-4 py-2">
                            @if($p['boarded'])
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Boarded</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            @if(!$p['boarded'])
                                <form action="{{ route('driver.markBoarded', $p['booking_seat_id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Mark Boarded</button>
                                </form>
                            @else
                                <span class="text-gray-400">Done</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No paid bookings for this trip yet.</p>
    @endif
</div>
@endsection
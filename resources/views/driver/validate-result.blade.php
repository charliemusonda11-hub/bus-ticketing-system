@extends('layouts.driver')

@section('title', 'Ticket Validation Result')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Booking: {{ $booking->booking_reference }}</h2>
    <p>Schedule: {{ $booking->schedule->route->origin }} → {{ $booking->schedule->route->destination }}</p>
    <p>Departure: {{ $booking->schedule->departure_time->format('Y-m-d H:i') }}</p>

    <h3 class="font-semibold mt-4 mb-2">Passengers</h3>
    <table class="min-w-full border">
        <thead><tr><th>Seat</th><th>Name</th><th>Phone</th><th>Boarded</th><th>Action</th></tr></thead>
        <tbody>
            @foreach($passengers as $p)
            <tr>
                <td class="border px-4 py-2">{{ $p['seat'] }}</td>
                <td class="border px-4 py-2">{{ $p['name'] }}</td>
                <td class="border px-4 py-2">{{ $p['phone'] ?? '-' }}</td>
                <td class="border px-4 py-2">
                    @if($p['boarded']) ✅ Boarded @else ⏳ Pending @endif
                </td>
                <td class="border px-4 py-2">
                    @if(!$p['boarded'])
                        <form action="{{ route('driver.markBoarded', $p['id']) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Mark Boarded</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('driver.validate.form') }}" class="inline-block mt-4 text-blue-600">Validate Another Ticket</a>
</div>
@endsection
@extends('layouts.driver')

@section('title', 'My Trips')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">All Assigned Trips</h2>
    <table class="min-w-full border">
        <thead>
            <tr><th>Date</th><th>Bus</th><th>Route</th><th>Departure</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr>
                <td class="border px-4 py-2">{{ $schedule->departure_time->format('Y-m-d') }}</td>
                <td class="border px-4 py-2">{{ $schedule->bus->company_name }}<br><small>{{ $schedule->bus->name }}</small></td>
                <td class="border px-4 py-2">{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</td>
                <td class="border px-4 py-2">{{ $schedule->departure_time->format('h:i A') }}</td>
                <td class="border px-4 py-2"><a href="{{ route('driver.manifest.show', $schedule) }}" class="text-blue-600">View Manifest</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $schedules->links() }}
</div>
@endsection
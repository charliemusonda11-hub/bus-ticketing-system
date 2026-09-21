@extends('layouts.driver')

@section('title', 'Dashboard')

@section('content')
<div class="grid md:grid-cols-2 gap-6">
    <!-- Today's Trips -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Today's Trips</h2>
        @if($todaySchedules->count())
            @foreach($todaySchedules as $schedule)
                <div class="border-b pb-3 mb-3">
                    <p class="font-semibold">{{ $schedule->bus->company_name }} - {{ $schedule->bus->name }}</p>
                    <p>{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</p>
                    <p>Departure: {{ $schedule->departure_time->format('h:i A') }}</p>
                    <a href="{{ route('driver.manifest.show', $schedule) }}" class="text-blue-600 hover:underline">View Manifest →</a>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No trips scheduled for today.</p>
        @endif
    </div>

    <!-- Upcoming Trips -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Upcoming Trips</h2>
        @if($upcomingSchedules->count())
            @foreach($upcomingSchedules as $schedule)
                <div class="border-b pb-3 mb-3">
                    <p class="font-semibold">{{ $schedule->bus->company_name }} - {{ $schedule->bus->name }}</p>
                    <p>{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</p>
                    <p>{{ $schedule->departure_time->format('D, M j, Y \a\t h:i A') }}</p>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No upcoming trips.</p>
        @endif
    </div>
</div>
@endsection
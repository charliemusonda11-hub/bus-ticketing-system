@extends('layouts.admin')

@section('title', 'Edit Schedule')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h2 class="text-xl font-semibold mb-4">Edit Schedule</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Bus</label>
            <select name="bus_id" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500" required>
                <option value="">Select Bus</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}" {{ old('bus_id', $schedule->bus_id) == $bus->id ? 'selected' : '' }}>
                        {{ $bus->company_name }} - {{ $bus->name }} ({{ $bus->plate_number }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Route</label>
            <select name="route_id" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500" required>
                <option value="">Select Route</option>
                @foreach($routes as $route)
                    <option value="{{ $route->id }}" {{ old('route_id', $schedule->route_id) == $route->id ? 'selected' : '' }}>
                        {{ $route->origin }} → {{ $route->destination }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Departure Time</label>
            <input type="datetime-local" name="departure_time" 
                value="{{ old('departure_time', $schedule->departure_time->format('Y-m-d\TH:i')) }}"
                class="w-full border-gray-300 rounded-lg focus:ring-indigo-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Price (K)</label>
            <input type="number" step="0.01" name="price" 
                value="{{ old('price', $schedule->price) }}"
                class="w-full border-gray-300 rounded-lg focus:ring-indigo-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Assign Driver (Optional)</label>
            <select name="driver_id" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500">
                <option value="">Unassigned</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ old('driver_id', $schedule->driver_id) == $driver->id ? 'selected' : '' }}>
                        {{ $driver->name }} ({{ $driver->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-between">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                Update Schedule
            </button>
            <a href="{{ route('admin.schedules.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-lg transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
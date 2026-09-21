@extends('layouts.admin')
@section('title', 'Add Schedule')
@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h2>Add Schedule</h2>
    <form action="{{ route('admin.schedules.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label>Bus</label>
            <select name="bus_id" class="w-full border-gray-300 rounded" required>
                <option value="">Select Bus</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}">{{ $bus->company_name }} - {{ $bus->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Route</label>
            <select name="route_id" class="w-full border-gray-300 rounded" required>
                <option value="">Select Route</option>
                @foreach($routes as $route)
                    <option value="{{ $route->id }}">{{ $route->origin }} → {{ $route->destination }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Departure Time</label>
            <input type="datetime-local" name="departure_time" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label>Price (K)</label>
            <input type="number" step="0.01" name="price" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
    <label class="block text-gray-700">Assign Driver (Optional)</label>
    <select name="driver_id" class="w-full border-gray-300 rounded">
        <option value="">Unassigned</option>
        @foreach($drivers as $driver)
            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                {{ $driver->name }} ({{ $driver->email }})
            </option>
        @endforeach
    </select>
</div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
        <a href="{{ route('admin.schedules.index') }}" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
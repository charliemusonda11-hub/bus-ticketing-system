@extends('layouts.admin')

@section('title', isset($bus) ? 'Edit Bus' : 'Add Bus')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h2 class="text-xl font-semibold mb-4">{{ isset($bus) ? 'Edit Bus' : 'Add New Bus' }}</h2>
    
    <form action="{{ isset($bus) ? route('admin.buses.update', $bus) : route('admin.buses.store') }}" method="POST">
        @csrf
        @if(isset($bus)) @method('PUT') @endif
        
        <div class="mb-4">
            <label class="block text-gray-700">Company Name</label>
            <input type="text" name="company_name" value="{{ old('company_name', $bus->company_name ?? '') }}" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Bus Name</label>
            <input type="text" name="name" value="{{ old('name', $bus->name ?? '') }}" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Plate Number</label>
            <input type="text" name="plate_number" value="{{ old('plate_number', $bus->plate_number ?? '') }}" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity', $bus->capacity ?? '') }}" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Type</label>
            <select name="type" class="w-full border-gray-300 rounded">
                <option value="minibus" {{ (old('type', $bus->type ?? '') == 'minibus') ? 'selected' : '' }}>Minibus</option>
                <option value="bus" {{ (old('type', $bus->type ?? '') == 'bus') ? 'selected' : '' }}>Bus</option>
            </select>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
        <a href="{{ route('admin.buses.index') }}" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
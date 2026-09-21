@extends('layouts.admin')

@section('title', isset($route) ? 'Edit Route' : 'Add Route')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h2 class="text-xl font-semibold mb-4">{{ isset($route) ? 'Edit Route' : 'Add New Route' }}</h2>
    
    <form action="{{ isset($route) ? route('admin.routes.update', $route) : route('admin.routes.store') }}" method="POST">
        @csrf
        @if(isset($route)) @method('PUT') @endif
        
        <div class="mb-4">
            <label class="block text-gray-700">Origin</label>
            <input type="text" name="origin" value="{{ old('origin', $route->origin ?? '') }}" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Destination</label>
            <input type="text" name="destination" value="{{ old('destination', $route->destination ?? '') }}" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Distance (km)</label>
            <input type="number" name="distance" value="{{ old('distance', $route->distance ?? '') }}" class="w-full border-gray-300 rounded">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
        <a href="{{ route('admin.routes.index') }}" class="ml-2 text-gray-600">Cancel</a>
    </form>


    
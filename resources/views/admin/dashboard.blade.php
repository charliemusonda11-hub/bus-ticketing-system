@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500">Total Buses</div>
        <div class="text-3xl font-bold">{{ $stats['buses'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500">Total Routes</div>
        <div class="text-3xl font-bold">{{ $stats['routes'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500">Schedules</div>
        <div class="text-3xl font-bold">{{ $stats['schedules'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500">Bookings</div>
        <div class="text-3xl font-bold">{{ $stats['bookings'] }}</div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Revenue</h3>
    <div class="text-4xl font-bold text-green-600">K{{ number_format($stats['revenue'], 2) }}</div>
</div>
@endsection
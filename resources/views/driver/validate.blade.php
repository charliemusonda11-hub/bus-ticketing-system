@extends('layouts.driver')

@section('title', 'Validate Ticket')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Enter Booking Reference</h2>
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('driver.validate.submit') }}">
        @csrf
        <input type="text" name="booking_reference" placeholder="e.g. BK-5F2A9C" class="w-full border-gray-300 rounded mb-4" required>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">Validate Ticket</button>
    </form>
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Add Driver')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h2 class="text-xl font-semibold mb-4">Add New Driver</h2>
    <form action="{{ route('admin.drivers.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Phone (Optional)</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 rounded">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save Driver</button>
        <a href="{{ route('admin.drivers.index') }}" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
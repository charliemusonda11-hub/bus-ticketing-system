@extends('layouts.auth')

@section('content')
<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create Account</h2>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required autofocus
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
        <input type="password" name="password" required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
        <input type="password" name="password_confirmation" required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <button type="submit"
        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
        Register
    </button>
</form>

<div class="text-center mt-6">
    <p class="text-sm text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Sign In</a></p>
</div>
@endsection
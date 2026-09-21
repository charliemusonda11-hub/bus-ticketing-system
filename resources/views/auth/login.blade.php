@extends('layouts.auth')

@section('content')
<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Sign In</h2>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
        <input type="password" name="password" required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="flex items-center justify-between mb-6">
        <label class="flex items-center">
            <input type="checkbox" name="remember" class="text-indigo-600 rounded">
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
    </div>
    <button type="submit"
        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
        Sign In
    </button>
</form>

<div class="text-center mt-6">
    <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Register</a></p>
</div>
@endsection
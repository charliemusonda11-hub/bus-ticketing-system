@extends('layouts.auth')
@section('content')
<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Reset Password</h2>
<p class="text-gray-600 mb-4">Enter your email to receive a reset link.</p>
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded mb-4" required>
    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded">Send Link</button>
</form>
<div class="text-center mt-4"><a href="{{ route('login') }}" class="text-indigo-600">Back to Login</a></div>
@endsection
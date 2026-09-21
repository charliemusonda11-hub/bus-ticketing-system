@extends('layouts.admin')
@section('title', 'Routes')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2>Routes</h2>
        <a href="{{ route('admin.routes.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Add Route</a>
    </div>
    @if(session('success'))<div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>@endif
    <table class="min-w-full border">
        <thead><tr><th>Origin</th><th>Destination</th><th>Distance (km)</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($routes as $route)
            <tr>
                <td class="border px-4 py-2">{{ $route->origin }}</td>
                <td class="border px-4 py-2">{{ $route->destination }}</td>
                <td class="border px-4 py-2">{{ $route->distance ?? '-' }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('admin.routes.edit', $route) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 ml-2">Delete</button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
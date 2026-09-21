@extends('layouts.admin')

@section('title', 'Manage Drivers')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Drivers</h2>
        <a href="{{ route('admin.drivers.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Add Driver</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border">
            <thead>
                <tr><th>Name</th><th>Email</th><th>Phone</th><th>Assigned Trips</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                <tr>
                    <td class="border px-4 py-2">{{ $driver->name }}</td>
                    <td class="border px-4 py-2">{{ $driver->email }}</td>
                    <td class="border px-4 py-2">{{ $driver->phone ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $driver->schedules->count() }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.drivers.edit', $driver) }}" class="text-blue-600 mr-2">Edit</a>
                        <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" class="inline" onsubmit="return confirm('Delete this driver?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
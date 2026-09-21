@extends('layouts.admin')

@section('title', 'Manage Buses')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Buses</h2>
        <a href="{{ route('admin.buses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Add Bus</a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead>
                <tr><th class="py-2 px-4 border-b">Company</th><th class="py-2 px-4 border-b">Bus Name</th><th class="py-2 px-4 border-b">Plate</th><th class="py-2 px-4 border-b">Capacity</th><th class="py-2 px-4 border-b">Type</th><th class="py-2 px-4 border-b">Actions</th></tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $bus->company_name }}</td>
                    <td class="py-2 px-4 border-b">{{ $bus->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $bus->plate_number }}</td>
                    <td class="py-2 px-4 border-b">{{ $bus->capacity }}</td>
                    <td class="py-2 px-4 border-b">{{ ucfirst($bus->type) }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('admin.buses.edit', $bus) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('admin.buses.destroy', $bus) }}" method="POST" class="inline" onsubmit="return confirm('Delete this bus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
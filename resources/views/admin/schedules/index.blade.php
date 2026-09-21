@extends('layouts.admin')
@section('title', 'Schedules')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2>Schedules</h2>
        <a href="{{ route('admin.schedules.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Add Schedule</a>
    </div>
    @if(session('success'))<div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>@endif
    <div class="overflow-x-auto">
        <table class="min-w-full border">
            <thead><tr><th>Bus</th><th>Route</th><th>Departure</th><th>Price</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($schedules as $schedule)
                <tr>
                    <td class="border px-4 py-2">{{ $schedule->bus->company_name }} - {{ $schedule->bus->name }}</td>
                    <td class="border px-4 py-2">{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</td>
                    <td class="border px-4 py-2">{{ $schedule->departure_time->format('Y-m-d H:i') }}</td>
                    <td class="border px-4 py-2">K{{ number_format($schedule->price, 2) }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 ml-2">Delete</button></form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
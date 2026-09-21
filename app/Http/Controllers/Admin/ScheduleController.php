<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'route'])->orderBy('departure_time', 'desc')->get();
        return view('admin.schedules.index', compact('schedules'));
    }

  public function create()
{
    $buses = Bus::all();
    $routes = Route::all();
    $drivers = User::where('role', 'driver')->orderBy('name')->get();
    return view('admin.schedules.create', compact('buses', 'routes', 'drivers'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date',
            'price' => 'required|numeric|min:0',
            'driver_id' => 'nullable|exists:users,id'
        ]);

        Schedule::create($validated);
        return redirect()->route('admin.schedules.index')->with('success', 'Schedule created.');
    }

  public function edit(Schedule $schedule)
{
    $buses = Bus::all();
    $routes = Route::all();
    $drivers = User::where('role', 'driver')->orderBy('name')->get();
    return view('admin.schedules.edit', compact('schedule', 'buses', 'routes', 'drivers'));
}

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date',
            'price' => 'required|numeric|min:0',
            'driver_id' => 'nullable|exists:users,id'
        ]);
        $schedule->update($validated);
        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Http\Request;

use function Symfony\Component\String\u;

class PublicScheduleController extends Controller
{
    //
    public function search1(Request $request)
{
    $schedules = Schedule::where('route_id', $request->route_id)
        ->whereDate('departure_time', $request->date)
        ->with('bus')
        ->get();
    return view('public.schedules', compact('schedules'));
}

public function search(Request $request)
{
    $request->validate([
        'origin' => 'required|string',
        'destination' => 'required|string',
        'date' => 'required|date|after_or_equal:today',
    ]);

    // 1. Find the routes that match the origin and destination
    // (We use pluck to handle cases where multiple IDs might exist for the same pair)
    $routeIds = Route::where('origin', $request->origin)
                    ->where('destination', $request->destination)
                    ->pluck('id');

    // 2. Query schedules matching those routes and the specific date
    $schedules = Schedule::with(['bus', 'route'])
                    ->whereIn('route_id', $routeIds)
                    ->whereDate('departure_time', $request->date)
                    ->orderBy('departure_time', 'asc')
                    ->get();

    return view('public.schedules', compact('schedules'));
}

/**
 * Function to display All Schedules
 * Returns a view with all schedules, including their associated bus and route information.
 */
public function index()
{
    $schedules = Schedule::with(['bus', 'route'])->orderBy('departure_time', 'asc')->get();
    return view('All_schedules', compact('schedules'));


}

}

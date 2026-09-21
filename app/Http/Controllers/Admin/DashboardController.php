<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'buses' => Bus::count(),
            'routes' => Route::count(),
            'schedules' => Schedule::count(),
            'bookings' => Booking::count(),
            'revenue' => Booking::where('status', 'paid')->sum('total_amount'),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
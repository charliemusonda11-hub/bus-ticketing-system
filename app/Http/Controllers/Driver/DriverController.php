<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\BookingSeat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    // Driver dashboard – show today's assigned trips
    public function dashboard()
    {
        $driverId = Auth::user()->id;
        $todaySchedules = Schedule::with(['bus', 'route'])
            ->where('driver_id', $driverId)
            ->whereDate('departure_time', today())
            ->orderBy('departure_time')
            ->get();
        
        $upcomingSchedules = Schedule::with(['bus', 'route'])
            ->where('driver_id', $driverId)
            ->whereDate('departure_time', '>', today())
            ->orderBy('departure_time')
            ->get();
        
        return view('driver.dashboard', compact('todaySchedules', 'upcomingSchedules'));
    }

    // List all schedules assigned to this driver (manifest overview)
    public function manifestIndex()
    {
        $schedules = Schedule::with(['bus', 'route'])
            ->where('driver_id', Auth::id())
            ->orderBy('departure_time', 'desc')
            ->paginate(10);
        return view('driver.manifest.index', compact('schedules'));
    }

    // Show passenger list for a specific schedule
    public function showManifest(Schedule $schedule)
    {
        // Ensure this schedule belongs to the logged driver
        if ($schedule->driver_id !== Auth::id()) {
            abort(403, 'This trip is not assigned to you.');
        }

        // Get all paid bookings for this schedule with their seats and passengers
        $bookings = Booking::with(['bookingSeats.seat', 'bookingSeats' => function($q) {
                $q->with('seat');
            }])
            ->where('schedule_id', $schedule->id)
            ->where('status', 'paid')
            ->get();

        // Flatten all booking seats for easier display
        $passengers = collect();
        foreach ($bookings as $booking) {
            foreach ($booking->bookingSeats as $bookingSeat) {
                $passengers->push([
                    'booking_reference' => $booking->booking_reference,
                    'passenger_name' => $bookingSeat->passenger_name,
                    'passenger_phone' => $bookingSeat->passenger_phone,
                    'seat_number' => $bookingSeat->seat->seat_number,
                    'boarded' => $bookingSeat->boarded,
                    'booking_seat_id' => $bookingSeat->id,
                ]);
            }
        }

        $stats = [
            'total_seats' => $schedule->bus->capacity,
            'booked_seats' => $passengers->count(),
            'checked_in' => $passengers->where('boarded', true)->count(),
        ];

        return view('driver.manifest.show', compact('schedule', 'passengers', 'stats'));
    }

    // Mark a specific passenger as boarded (booking_seat)
    public function markBoarded(BookingSeat $bookingSeat)
    {
        // Verify that the booking seat belongs to a schedule assigned to this driver
        $schedule = $bookingSeat->booking->schedule;
        if ($schedule->driver_id !== Auth::id()) {
            abort(403);
        }

        $bookingSeat->update(['boarded' => true]);

        return back()->with('success', "Passenger {$bookingSeat->passenger_name} marked as boarded.");
    }

    // Show ticket validation form
    public function validateForm()
    {
        return view('driver.validate');
    }

    // Process ticket validation by booking reference
    public function validateTicket(Request $request)
    {
        $request->validate([
            'booking_reference' => 'required|string|exists:bookings,booking_reference',
        ]);

        $booking = Booking::with(['schedule', 'bookingSeats.seat'])
            ->where('booking_reference', $request->booking_reference)
            ->first();

        // Check if booking is paid
        if ($booking->status !== 'paid') {
            return back()->with('error', 'This booking is not paid yet.');
        }

        // Check if the schedule belongs to this driver
        if ($booking->schedule->driver_id !== Auth::id()) {
            return back()->with('error', 'This ticket is not for your assigned trip.');
        }

        // Prepare passenger data
        $passengers = [];
        foreach ($booking->bookingSeats as $bs) {
            $passengers[] = [
                'id' => $bs->id,
                'name' => $bs->passenger_name,
                'phone' => $bs->passenger_phone,
                'seat' => $bs->seat->seat_number,
                'boarded' => $bs->boarded,
            ];
        }

        return view('driver.validate-result', compact('booking', 'passengers'));
    }
}
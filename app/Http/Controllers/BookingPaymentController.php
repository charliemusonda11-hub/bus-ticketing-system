<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Schedule;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Writer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingPaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $data = session('booking_data');

        if (!$data) {
            return response()->json(['status' => false]);
        }

        $amount = $data['total_amount'] * 100;
        $reference = 'BOOK_' . strtoupper(Str::random(10));

        $response = Http::withOptions(['verify' => false])
            ->withToken(env('PAYSTACK_SECRET_KEY'))
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $data['contact_email'],
                'amount' => $amount,
                'reference' => $reference,
                'callback_url' => url('/booking/callback'),
            ]);

        if (!$response->successful()) {
            return response()->json(['status' => false]);
        }

        return response()->json([
            'status' => true,
            'reference' => $reference,
            'amount' => $amount,
            'key' => env('PAYSTACK_PUBLIC_KEY'),
        ]);
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');
        $data = session('booking_data');

        if (!$data) {
            return redirect('/')->with('error', 'Session expired');
        }

        $response = Http::withOptions(['verify' => false])
            ->withToken(env('PAYSTACK_SECRET_KEY'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->successful() && $response['data']['status'] === 'success') {

         $booking = DB::transaction(function () use ($data, $reference) {

    // Check seats again
    $schedule = Schedule::findOrFail($data['schedule_id']);

    $bookedSeatIds = $schedule->booked_seats ?? [];

    if (array_intersect($data['selected_seats'], $bookedSeatIds)) {
        throw new \Exception('Seats already booked');
    }

    $booking_ref = 'BOOK_' . strtoupper(Str::random(10));

    $booking = Booking::create([
        'booking_reference' => $booking_ref,
        'schedule_id' => $data['schedule_id'],
        'contact_name' => $data['contact_name'],
        'contact_email' => $data['contact_email'],
        'contact_phone' => $data['contact_phone'],
        'total_amount' => $data['total_amount'],
        'status' => 'paid',
        'transaction_ref' => $reference,
    ]);

    foreach ($data['selected_seats'] as $seatId) {

        BookingSeat::create([
            'booking_id' => $booking->id,
            'seat_id' => $seatId,
            'passenger_name' =>
                $data['passenger_details'][$seatId]['name'],

            'passenger_phone' =>
                $data['passenger_details'][$seatId]['phone'] ?? null,
        ]);
    }

    return $booking;
});


// Load relationships required by the ticket PDF
$booking->load([
    'schedule.bus',
    'seats.seat',
]);


// Send confirmation email with PDF attachment
 try {
    Mail::to($booking->contact_email)
        ->send(new BookingConfirmationMail($booking));  
 }
 catch (\Exception $e) {
    // Log the error for debugging
    Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
    // Optionally, you can notify the user that the email failed to send
    return redirect()->route('booking.success', ['ref' => $booking->booking_reference])
      ->with('warning', 'Booking successful, but failed to send confirmation email.');
}


// Clear session
session()->forget('booking_data');


// Redirect to success page
return redirect()->route('booking.success', [
    'ref' => $booking->booking_reference
]);
        } else {
            return redirect('/')->with('error', 'Payment verification failed');
        }
    }

public function download($ref)
{
    $booking = Booking::where('booking_reference', $ref)
        ->with(['seats', 'schedule.bus'])
        ->firstOrFail();


    $pdf = Pdf::loadView('booking.ticket-pdf', compact('booking'));

    return $pdf->download('ticket-'.$booking->booking_reference.'.pdf');
}


}
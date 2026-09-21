<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingPaymentController;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Driver\DriverController;

Route::get('/', function () {
    return view('public.index');
})->name('home');
/**Guest */
 Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
   Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
//login
    Route::get('/seat-selection/{schedule}', function (Schedule $schedule) {
    return view('public.seat-select', compact('schedule'));
})->name('seat.selection');
/*booking payment route */
Route::get('/booking-summary', function () {
    return view('booking.summary');
})->name('booking.summary');

Route::post('/booking/payment/initiate', [BookingPaymentController::class, 'initiate'])
    ->name('booking.payment.initiate');

Route::get('/booking/callback', [BookingPaymentController::class, 'callback'])
    ->name('booking.callback');



Route::get('/booking/success/{ref}', function ($ref) {
    $booking = Booking::where('booking_success', $ref)->firstOrFail();
    
    return view('booking.success', compact('booking'));
})->name('booking.success');

Route::get('/booking/download/{ref}', [BookingPaymentController::class, 'download'])
    ->name('booking.download');
    //search
    Route::get('/booking/search', function () {
    return view('booking.search');
})->name('booking.search');

Route::post('/booking/search/sumit', function (Request $request) {
    $booking = Booking::where('booking_reference', $request->booking_reference)->first();
    $ref = $booking->transaction_ref;
    if (!$booking) {
        return back()->with('error', 'Booking not found');
    }

    return redirect()->route('booking.success', $ref);
})->name('booking.search.submit');

/**All drivers routes */


Route::middleware(['auth', 'driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/', [DriverController::class, 'dashboard'])->name('dashboard');
    Route::get('/manifest', [DriverController::class, 'manifestIndex'])->name('manifest.index');
    Route::get('/manifest/{schedule}', [DriverController::class, 'showManifest'])->name('manifest.show');
    Route::post('/mark-boarded/{bookingSeat}', [DriverController::class, 'markBoarded'])->name('markBoarded');
    Route::get('/validate', [DriverController::class, 'validateForm'])->name('validate.form');
    Route::post('/validate', [DriverController::class, 'validateTicket'])->name('validate.submit');
});

//end driver routes

//
Route::prefix('admin')->name('admin.')->middleware('auth', 'admin')->group(function () {
     Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('buses', App\Http\Controllers\Admin\BusController::class);
    Route::resource('routes', App\Http\Controllers\Admin\RouteController::class);
    Route::resource('schedules', App\Http\Controllers\Admin\ScheduleController::class);
        Route::resource('bookings', BookingController::class);
Route::resource('drivers', App\Http\Controllers\Admin\DriverController::class);
      
});
  //logout route
        Route::post('/logout', function () {
            Auth::logout();
            return redirect()->route('home');
        })->name('logout');
//admin route no middleware
// schedules routes
Route::get('/all/schedule', [App\Http\Controllers\PublicScheduleController::class, 'index'])->name('schedules.index');
Route::get('/schedules/search', [App\Http\Controllers\PublicScheduleController::class, 'search'])->name('schedules.search');

//test bar code
Route::get('/test', function () {
   // Save to local path
QrCode::format('png')->size(300)->generate('Data', public_path('qrcodes/code.png'));

// Stream for download
return response()->streamDownload(function () {
    echo QrCode::format('png')->size(300)->generate('Data');
}, 'qrcode.png');
});



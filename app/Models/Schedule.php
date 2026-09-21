<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
       protected $fillable = ['bus_id', 'route_id', 'departure_time', 'price'];
    protected $casts = ['departure_time' => 'datetime'];
    
    public function bus() { return $this->belongsTo(Bus::class); }
    public function route() { return $this->belongsTo(Route::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
    
    // Get seats that are already booked (paid) for this schedule
    public function getBookedSeatsAttribute()
    {
        return BookingSeat::whereHas('booking', function($q) {
            $q->where('schedule_id', $this->id)
              ->whereIn('status', ['paid', 'pending']); // pending also blocked
        })->pluck('seat_id')->toArray();
    }


}

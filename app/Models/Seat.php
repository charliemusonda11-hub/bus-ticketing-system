<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    //
    protected $fillable = ['bus_id', 'seat_number'];
    public function bus() { return $this->belongsTo(Bus::class); }
    public function bookingSeats() { return $this->hasMany(BookingSeat::class); }
}

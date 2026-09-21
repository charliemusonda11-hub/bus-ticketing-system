<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    //
    protected $fillable = [ 
        'booking_reference',
        'schedule_id',
        'contact_name',
        'contact_email',
        'contact_phone',
        'total_amount',
        'status',
        'transaction_ref'
    ];
    //auto generate booking reference
   /* protected static function boot()
    {        parent::boot();
        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'BOOK_' . strtoupper(Str::random(10));
            }
        });
    }*/

        public function schedule()
{
    return $this->belongsTo(Schedule::class);
}
public function seats()
{
    return $this->hasMany(BookingSeat::class); // or whatever your pivot/model is
}

}

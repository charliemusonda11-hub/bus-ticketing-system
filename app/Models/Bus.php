<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    //
       protected $fillable = ['name', 'plate_number', 'capacity', 'type', 'company_name'];

         public function schedules() {
             return $this->hasMany(Schedule::class);
              }
    public function seats() { 
        return $this->hasMany(Seat::class);
         }
}

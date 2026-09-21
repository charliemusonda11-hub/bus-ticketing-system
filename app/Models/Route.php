<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    //
       protected $fillable = ['origin', 'destination', 'distance'];
    public function schedules() { return $this->hasMany(Schedule::class); }
}

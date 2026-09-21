<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run()
{
    // Create a bus
    $bus = Bus::create([
        'name' => 'Luxury Cruiser',
        'plate_number' => 'ABC123',
        'capacity' => 12,
        'type' => 'bus',
        'company_name' => 'Mazhandu Family',
    ]);
    
    // Generate seats (A1, A2, ..., C4 for 12 seats)
    $rows = ['A', 'B', 'C'];
    $seatsPerRow = 4;
    foreach ($rows as $row) {
        for ($i = 1; $i <= $seatsPerRow; $i++) {
            Seat::create([
                'bus_id' => $bus->id,
                'seat_number' => $row . $i,
            ]);
        }
    }
    
    $route = Route::create(['origin' => 'Lusaka', 'destination' => 'Ndola', 'distance' => 350]);
    
    Schedule::create([
        'bus_id' => $bus->id,
        'route_id' => $route->id,
        'departure_time' => now()->addDay()->setTime(8, 0),
        'price' => 150.00,
    ]);
}
}

<?php
namespace App\Http\Controllers\Admin;

use App\Models\Bus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::orderBy('company_name')->orderBy('name')->get();
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|unique:buses',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:minibus,bus',
            'company_name' => 'required|string|max:255',
        ]);

        $bus = Bus::create($validated);
        
        // Generate seats for this bus based on capacity
        $this->generateSeats($bus);
        
        return redirect()->route('admin.buses.index')->with('success', 'Bus created successfully.');
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|unique:buses,plate_number,' . $bus->id,
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:minibus,bus',
            'company_name' => 'required|string|max:255',
        ]);

        $bus->update($validated);
        return redirect()->route('admin.buses.index')->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect()->route('admin.buses.index')->with('success', 'Bus deleted successfully.');
    }

    private function generateSeats(Bus $bus)
    {
        $rows = range('A', 'Z');
        $seatsPerRow = 4;
        $seatCount = 0;
        
        foreach ($rows as $row) {
            for ($i = 1; $i <= $seatsPerRow; $i++) {
                if ($seatCount >= $bus->capacity) break 2;
                \App\Models\Seat::create([
                    'bus_id' => $bus->id,
                    'seat_number' => $row . $i,
                ]);
                $seatCount++;
            }
        }
    }
}
<?php


namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')->orderBy('name')->get();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'driver',
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver created successfully.');
    }

    public function edit(User $driver)
    {
        // Ensure we only edit driver role
        if ($driver->role !== 'driver') abort(404);
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, User $driver)
    {
        if ($driver->role !== 'driver') abort(404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $driver->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $driver->name = $validated['name'];
        $driver->email = $validated['email'];
        if (!empty($validated['password'])) {
            $driver->password = Hash::make($validated['password']);
        }
        $driver->phone = $validated['phone'] ?? null;
        $driver->save();

        return redirect()->route('admin.drivers.index')->with('success', 'Driver updated successfully.');
    }

    public function destroy(User $driver)
    {
        if ($driver->role !== 'driver') abort(404);
        
        // Optionally: reassign schedules to null before deleting
        $driver->schedules()->update(['driver_id' => null]);
        $driver->delete();

        return redirect()->route('admin.drivers.index')->with('success', 'Driver deleted successfully.');
    }
}
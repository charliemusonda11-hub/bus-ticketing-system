<?php

namespace App\Http\Controllers\Admin;

use App\Models\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::orderBy('origin')->orderBy('destination')->get();
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'distance' => 'nullable|numeric|min:0',
        ]);
        Route::create($validated);
        return redirect()->route('admin.routes.index')->with('success', 'Route created.');
    }

    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'distance' => 'nullable|numeric|min:0',
        ]);
        $route->update($validated);
        return redirect()->route('admin.routes.index')->with('success', 'Route updated.');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.index')->with('success', 'Route deleted.');
    }
}
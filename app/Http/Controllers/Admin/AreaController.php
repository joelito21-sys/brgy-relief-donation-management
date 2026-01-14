<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of areas.
     */
    public function index()
    {
        $areas = Area::latest()->paginate(10);
        return view('admin.areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new area.
     */
    public function create()
    {
        return view('admin.areas.create');
    }

    /**
     * Store a newly created area.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:areas,name',
            'code' => 'required|string|max:10|unique:areas,code',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        Area::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()
            ->route('admin.areas.index')
            ->with('success', 'Area created successfully.');
    }

    /**
     * Show the form for editing the specified area.
     */
    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    /**
     * Update the specified area.
     */
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:areas,name,' . $area->id,
            'code' => 'required|string|max:10|unique:areas,code,' . $area->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $area->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()
            ->route('admin.areas.index')
            ->with('success', 'Area updated successfully.');
    }

    /**
     * Remove the specified area.
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()
            ->route('admin.areas.index')
            ->with('success', 'Area deleted successfully.');
    }
}

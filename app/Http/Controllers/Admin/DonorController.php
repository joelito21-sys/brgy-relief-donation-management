<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class DonorController extends Controller
{
    public function index()
    {
        $donors = Donor::latest()->paginate(10);
        return view('admin.donors.index', compact('donors'));
    }

    public function create()
    {
        return view('admin.donors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:donors',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'organization' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Donor::create($validated);

        return redirect()->route('admin.donors.index')
            ->with('success', 'Donor created successfully.');
    }

    public function edit(Donor $donor)
    {
        return view('admin.donors.edit', compact('donor'));
    }

    public function update(Request $request, Donor $donor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('donors')->ignore($donor->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'organization' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Only hash password if it's being updated
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $donor->update($validated);

        return redirect()->route('admin.donors.index')
            ->with('success', 'Donor updated successfully.');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();
        return redirect()->route('admin.donors.index')
            ->with('success', 'Donor deleted successfully.');
    }

    /**
     * Display the specified donor.
     */
    public function show(Donor $donor)
    {
        return view('admin.donors.show', compact('donor'));
    }

    /**
     * Toggle the status of the specified donor.
     */
    public function toggleStatus(Donor $donor)
    {
        $donor->update([
            'status' => $donor->status === 'active' ? 'inactive' : 'active'
        ]);

        $status = $donor->status === 'active' ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.donors.index')
            ->with('success', "Donor {$status} successfully.");
    }
}
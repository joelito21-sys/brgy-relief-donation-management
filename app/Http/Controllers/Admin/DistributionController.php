<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use App\Models\ReliefRequest;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    public function index()
    {
        $notifications = \App\Models\DistributionNotification::with(['reliefRequest', 'sentBy'])
            ->latest()
            ->paginate(10);
            
        return view('admin.distributions.index', compact('notifications'));
    }

    public function create()
    {
        $requests = ReliefRequest::where('status', 'approved')
            ->whereDoesntHave('distribution')
            ->get();
        
        // Get areas for general distribution
        $areas = \App\Models\Area::all();
            
        return view('admin.distributions.create', compact('requests', 'areas'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'distribution_type' => 'required|in:general,specific',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'scheduled_for' => 'required|date|after:now',
                'location' => 'required|string|max:255',
                'status' => 'required|in:scheduled,in_progress,completed,cancelled',
                'notes' => 'nullable|string',
            ];
            
            // Add conditional validation rules
            if ($request->distribution_type === 'general') {
                $rules['area_id'] = 'required|exists:areas,id';
            } elseif ($request->distribution_type === 'specific') {
                $rules['relief_request_id'] = 'required|exists:relief_requests,id|unique:distributions,relief_request_id';
            }
            
            $validated = $request->validate($rules);

            $distribution = Distribution::create([
                'relief_request_id' => $validated['distribution_type'] === 'specific' ? $validated['relief_request_id'] : null,
                'distributed_by' => auth('admin')->id(),
                'distribution_date' => $validated['scheduled_for'],
                'scheduled_for' => $validated['scheduled_for'],
                'status' => $validated['status'],
                'notes' => $validated['notes'],
                'area_id' => $validated['distribution_type'] === 'general' ? $validated['area_id'] : null,
            ]);
            
            // Update relief request status if specific distribution
            if ($validated['distribution_type'] === 'specific' && $distribution->reliefRequest) {
                $distribution->reliefRequest->update([
                    'status' => 'in_distribution'
                ]);
            }

            $message = $validated['distribution_type'] === 'general' 
                ? 'General distribution announced successfully.' 
                : 'Distribution scheduled successfully.';

            return redirect()->route('admin.distributions.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating distribution: ' . $e->getMessage());
        }
    }

    public function show(Distribution $distribution)
    {
        $distribution->load(['reliefRequest', 'distributedBy']);
        return view('admin.distributions.show', compact('distribution'));
    }

    public function edit(Distribution $distribution)
    {
        $requests = ReliefRequest::where('status', 'approved')
            ->whereDoesntHave('distribution')
            ->orWhere('id', $distribution->relief_request_id)
            ->get();
            
        return view('admin.distributions.edit', compact('distribution', 'requests'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $validated = $request->validate([
            'relief_request_id' => 'required|exists:relief_requests,id|unique:distributions,relief_request_id,' . $distribution->id,
            'distribution_date' => 'required|date',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $distribution->update($validated);

        // Update relief request status if distribution is completed
        if ($validated['status'] === 'completed') {
            $distribution->reliefRequest->update([
                'status' => 'completed'
            ]);
        }

        return redirect()->route('admin.distributions.index')
            ->with('success', 'Distribution updated successfully.');
    }

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();
        return redirect()->route('admin.distributions.index')
            ->with('success', 'Distribution deleted successfully.');
    }
}

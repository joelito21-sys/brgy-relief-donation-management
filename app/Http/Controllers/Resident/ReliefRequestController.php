<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\ReliefRequest;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReliefRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:resident');
        $this->middleware('resident.approved');
    }

    /**
     * Store a new relief request.
     */
    /**
     * Store a new relief request.
     */
    public function store(Request $request)
    {
        \Log::info('Relief request submission attempt', $request->all());
        
        try {
            $resident = Auth::guard('resident')->user();
            \Log::info('Resident ID: ' . $resident->id);
            
            // Process assistance types to include amount for cash
            $assistanceTypes = $request->assistance_types ?? [];
            if (in_array('cash', $assistanceTypes) && $request->cash_amount) {
                $key = array_search('cash', $assistanceTypes);
                if ($key !== false) {
                     $assistanceTypes[$key] = 'Cash (₱' . number_format($request->cash_amount) . ')';
                }
            }
            
            // Save all form data without validation for testing
            $reliefRequest = ReliefRequest::create([
                'resident_id' => $resident->id,
                'full_name' => $request->full_name,
                'contact_number' => $request->contact_number,
                'email_address' => $request->email_address,
                'id_number' => $request->id_number,
                'complete_address' => $request->complete_address,
                'city_municipality' => $request->city_municipality,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'household_size' => $request->household_size,
                'urgency_level' => $request->urgency_level,
                'assistance_types' => $assistanceTypes,
                'description' => $request->description,
                'children_count' => $request->children_count ?? 0,
                'elderly_count' => $request->elderly_count ?? 0,
                'pwd_count' => $request->pwd_count ?? 0,
                'pregnant_count' => $request->pregnant_count ?? 0,
                'additional_message' => $request->additional_message,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'reason' => $request->description,
                'family_members' => $request->household_size,
                'status' => 'pending',
                'submitted_at' => now(),
            ]);

            \Log::info('Relief request created with ID: ' . $reliefRequest->id);

            // Send notification to admin
            try {
                \Illuminate\Support\Facades\Mail::to('serafinjoelito21@gmail.com')
                    ->send(new \App\Mail\ReliefRequestSubmittedAdminMail($reliefRequest));
                \Log::info('Admin notification email sent');
            } catch (\Exception $e) {
                \Log::error('Failed to send admin notification email: ' . $e->getMessage());
            }

            // Send confirmation notification to resident (email + database)
            try {
                $resident->notify(new \App\Notifications\ReliefRequestSubmitted($reliefRequest));
                \Log::info('Resident notification sent');
            } catch (\Exception $e) {
                \Log::error('Failed to send resident notification: ' . $e->getMessage());
            }

            return redirect()
                ->route('resident.relief-requests.index')
                ->with('success', 'Relief request submitted successfully! A confirmation email has been sent to you. We will review your request and contact you soon.');

        } catch (\Exception $e) {
            \Log::error('Relief request submission failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to submit relief request. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified relief request.
     */
    public function show($id)
    {
        $resident = Auth::guard('resident')->user();
        $reliefRequest = $resident->reliefRequests()->with(['items', 'distributions'])->findOrFail($id);
        
        return view('resident.relief-requests.show', compact('reliefRequest'));
    }

    /**
     * Show the form for editing the specified relief request.
     */
    public function edit($id)
    {
        $resident = Auth::guard('resident')->user();
        // Only allow editing if pending
        $reliefRequest = $resident->reliefRequests()->where('status', 'pending')->findOrFail($id);
        
        return view('resident.relief-requests.edit', compact('reliefRequest'));
    }

    /**
     * Update the specified relief request in storage.
     */
    public function update(Request $request, $id)
    {
        $resident = Auth::guard('resident')->user();
        $reliefRequest = $resident->reliefRequests()->where('status', 'pending')->findOrFail($id);

        \Log::info('Relief request update attempt', $request->all());

        try {
            // Process assistance types to include amount for cash
            $assistanceTypes = $request->assistance_types ?? [];
            if (in_array('cash', $assistanceTypes) && $request->cash_amount) {
                $key = array_search('cash', $assistanceTypes);
                if ($key !== false) {
                    $assistanceTypes[$key] = 'Cash (₱' . number_format($request->cash_amount) . ')';
                }
            }

            $reliefRequest->update([
                'full_name' => $request->full_name,
                'contact_number' => $request->contact_number,
                'email_address' => $request->email_address,
                'id_number' => $request->id_number,
                'complete_address' => $request->complete_address,
                'city_municipality' => $request->city_municipality,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'household_size' => $request->household_size,
                'urgency_level' => $request->urgency_level,
                'assistance_types' => $assistanceTypes,
                'description' => $request->description,
                'children_count' => $request->children_count ?? 0,
                'elderly_count' => $request->elderly_count ?? 0,
                'pwd_count' => $request->pwd_count ?? 0,
                'pregnant_count' => $request->pregnant_count ?? 0,
                'additional_message' => $request->additional_message,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'reason' => $request->description,
                'family_members' => $request->household_size,
            ]);

            return redirect()
                ->route('resident.relief-requests.index')
                ->with('success', 'Relief request updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Relief request update failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update relief request. Please try again.');
        }
    }
}

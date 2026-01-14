<?php

namespace App\Http\Controllers\Donor\Donation;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class MedicineDonationController extends BaseDonationController
{
    protected $donationType = 'medicine';
    
    public function __construct()
    {
        $this->middleware('auth:donor');
    }
    
    /**
     * Show the medicine donation form
     */
    public function index()
    {
        return parent::index();
    }
    
    /**
     * Show the medicine donation form (alias for backward compatibility)
     */
    public function create()
    {
        return $this->index();
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        
        $donor = Auth::guard('donor')->user();
        
        // Create the donation
        $donation = new Donation([
            'donor_id' => $donor->id,
            'type' => $this->donationType,
            'status' => 'pending',
            'donor_name' => $donor->name,
            'donor_email' => $donor->email,
            'donor_phone' => $donor->phone ?? '',
            'donor_address' => $donor->address ?? '',
            'delivery_method' => $validated['delivery_method'],
            'pickup_date' => $validated['preferred_date'],
            'pickup_address' => $validated['delivery_address'] ?? '',
            'message' => $validated['special_instructions'] ?? null,
        ]);
        
        // Store medicine details as JSON
        $medicineDetails = [
            'name' => $validated['name'],
            'quantity' => $validated['quantity'],
            'expiry_date' => $validated['expiry_date'],
            'condition' => $validated['condition'],
            'requires_prescription' => $validated['requires_prescription'],
        ];
        
        $donation->medicine_type = json_encode($medicineDetails);
        $donation->quantity = $validated['quantity'];
        
        $donation->save();
        
        return redirect()->route('donor.donations.thank-you', $donation->id);
    }
    
    protected function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:1',
            'expiry_date' => 'required|date|after:today',
            'condition' => 'required|in:sealed,unsealed',
            'requires_prescription' => 'required|boolean',
            'special_instructions' => 'nullable|string|max:1000',
            'delivery_method' => 'required|in:pickup,delivery',
            'preferred_date' => 'required|date|after:today',
            'delivery_address' => 'nullable|string|max:500',
        ];
    }
    
    // Additional methods for medicine donation
    public function showGuidelines()
    {
        // Show medicine donation guidelines
    }
    
    public function checkExpiration($expiryDate)
    {
        // Check if medicine is expired
        return now()->lt($expiryDate);
    }
    
    public function schedulePickup(Request $request)
    {
        // Schedule pickup logic
    }
}

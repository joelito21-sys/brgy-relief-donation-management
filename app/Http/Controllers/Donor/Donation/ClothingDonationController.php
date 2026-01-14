<?php

namespace App\Http\Controllers\Donor\Donation;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class ClothingDonationController extends BaseDonationController
{
    protected $donationType = 'clothing';
    
    public function __construct()
    {
        $this->middleware('auth:donor');
    }
    
    /**
     * Show the clothing donation form
     */
    public function index()
    {
        return parent::index();
    }
    
    /**
     * Show the clothing donation form (alias for backward compatibility)
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
            'pickup_address' => $validated['delivery_address'],
            'message' => $validated['special_instructions'] ?? null,
        ]);
        
        // Store clothing items details
        $clothingItems = [];
        foreach ($validated['clothing_items'] as $item) {
            $clothingItems[] = [
                'type' => $item['type'],
                'size' => $item['size'] ?? '',
                'quantity' => $item['quantity'],
                'condition' => $item['condition'],
                'gender' => $item['gender'] ?? 'unisex',
                'season' => $item['season'] ?? 'all_season',
                'description' => $item['description'] ?? '',
            ];
        }
        
        // Store clothing items as JSON
        $donation->clothing_types = json_encode($clothingItems);
        $donation->quantity = array_sum(array_column($clothingItems, 'quantity'));
        
        $donation->save();
        
        return redirect()->route('donor.donations.thank-you', $donation->id);
    }
    
    protected function getValidationRules()
    {
        return [
            'clothing_items' => 'required|array|min:1',
            'clothing_items.*.type' => 'required|string|max:50',
            'clothing_items.*.size' => 'nullable|string|max:50',
            'clothing_items.*.quantity' => 'required|numeric|min:1',
            'clothing_items.*.condition' => 'required|string|max:50',
            'clothing_items.*.gender' => 'nullable|string|max:50',
            'clothing_items.*.season' => 'nullable|string|max:50',
            'clothing_items.*.description' => 'nullable|string|max:500',
            'donation_type' => 'required|in:individual,clothing_drive,retailer,other',
            'preferred_date' => 'required|date|after:today',
            'delivery_method' => 'required|in:dropoff,pickup',
            'delivery_address' => 'required|string|max:500',
            'special_instructions' => 'nullable|string|max:1000',
        ];
    }
    
    // Additional methods for clothing donation
    public function showDonationGuidelines()
    {
        // Show clothing donation guidelines
    }
    
    public function schedulePickup(Request $request)
    {
        // Schedule pickup logic
    }
}

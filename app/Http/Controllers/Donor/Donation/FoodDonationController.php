<?php

namespace App\Http\Controllers\Donor\Donation;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class FoodDonationController extends BaseDonationController
{
    protected $donationType = 'food';
    
    public function __construct()
    {
        $this->middleware('auth:donor');
    }
    
    /**
     * Show the food donation form
     */
    public function index()
    {
        return parent::index();
    }
    
    /**
     * Show the food donation form (alias for backward compatibility)
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
        
        // Store food items details
        $foodItems = [];
        foreach ($validated['food_items'] as $item) {
            $foodItems[] = [
                'type' => $item['type'],
                'name' => $item['name'] ?? '',
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
                'description' => $item['description'] ?? '',
                'expiry_date' => $item['expiry_date'] ?? null,
                'storage_requirements' => $item['storage_requirements'] ?? 'room_temperature',
            ];
        }
        
        // Store food items as JSON
        $donation->food_type = json_encode($foodItems);
        $donation->food_name = count($foodItems) . ' food items';
        $donation->quantity = array_sum(array_column($foodItems, 'quantity'));
        
        $donation->save();
        
        return redirect()->route('donor.donations.thank-you', $donation->id);
    }
    
    protected function getValidationRules()
    {
        return [
            'food_items' => 'required|array|min:1',
            'food_items.*.type' => 'required|string|max:50',
            'food_items.*.name' => 'nullable|string|max:255',
            'food_items.*.quantity' => 'required|numeric|min:1',
            'food_items.*.unit' => 'required|string|max:50',
            'food_items.*.description' => 'nullable|string|max:500',
            'food_items.*.expiry_date' => 'nullable|date|after:today',
            'food_items.*.storage_requirements' => 'nullable|in:room_temperature,refrigerated,frozen',
            'donation_type' => 'required|in:individual,food_drive,restaurant,grocery,other',
            'preferred_date' => 'required|date|after:today',
            'delivery_method' => 'required|in:dropoff,pickup',
            'delivery_address' => 'required|string|max:500',
            'special_instructions' => 'nullable|string|max:1000',
        ];
    }
    
    // Additional methods for food donation
    public function showPickupInfo()
    {
        // Show pickup information
    }
    
    public function schedulePickup(Request $request)
    {
        // Schedule pickup logic
    }
}

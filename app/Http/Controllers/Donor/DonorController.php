<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorController extends Controller
{
    /**
     * Show the donor dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $donor = Auth::guard('donor')->user();
        
        // Get total donations amount
        $totalDonations = $donor->donations()
            ->where('status', 'completed')
            ->sum('amount');
            
        // Get last donation date
        $lastDonation = $donor->donations()
            ->where('status', 'completed')
            ->latest('created_at')
            ->first();
            
        // Get recent donations (last 5)
        $recentDonations = $donor->donations()
            ->with('donor')
            ->latest('created_at')
            ->limit(5)
            ->get();
            
        // Get donation statistics
        $donationStats = [
            'total' => $donor->donations()->count(),
            'completed' => $donor->donations()->where('status', 'completed')->count(),
            'pending' => $donor->donations()->where('status', 'pending')->count(),
            'cancelled' => $donor->donations()->where('status', 'cancelled')->count(),
        ];
        
        // Get recent activities (donations and updates)
        $recentActivities = $donor->donations()
            ->select('id', 'type', 'status', 'amount', 'created_at', 'updated_at')
            ->with('donor')
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->map(function($donation) {
                return [
                    'type' => 'donation',
                    'title' => ucfirst($donation->type) . ' Donation ' . ucfirst($donation->status),
                    'description' => 'Your ' . strtolower($donation->type) . ' donation of ₱' . number_format($donation->amount, 2) . ' has been ' . $donation->status,
                    'date' => $donation->updated_at,
                    'icon' => $donation->status === 'completed' ? 'check-circle' : 'clock',
                    'iconColor' => $donation->status === 'completed' ? 'text-green-500' : 'text-yellow-500'
                ];
            });
        
        return view('donor.dashboard', [
            'user' => $donor,
            'totalDonations' => $totalDonations,
            'lastDonation' => $lastDonation,
            'recentDonations' => $recentDonations,
            'donationStats' => $donationStats,
            'recentActivities' => $recentActivities,
        ]);
    }
    
    /**
     * Show donor activities.
     *
     * @return \Illuminate\View\View
     */
    public function activities()
    {
        // Get all donations and their related activities
        $donations = auth('donor')->user()->donations()
            ->with(['donationItems', 'activities'])
            ->whereHas('activities')
            ->latest('created_at')
            ->get();
            
        // Flatten all activities from donations
        $activities = collect();
        foreach ($donations as $donation) {
            $activities = $activities->merge($donation->activities->map(function($activity) use ($donation) {
                $activity->donation = $donation;
                return $activity;
            }));
        }
        
        // Sort activities by created_at in descending order
        $activities = $activities->sortByDesc('created_at')->values();
        
        return view('donor.activities.index', compact('activities'));
    }
    
    /**
     * Show the donor profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::guard('donor')->user();
        return view('donor.profile.index', compact('user'));
    }

    /**
     * Update the donor's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('donor')->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:donors,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('donor.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the donation options page.
     *
     * @return \Illuminate\View\View
     */
    public function showDonateOptions()
    {
        return view('donor.donations.types.index');
    }

    /**
     * @deprecated Use CashDonationController::create() instead
     */
    public function showCashDonationForm()
    {
        return redirect()->route('donor.donations.cash.index');
    }

    /**
     * @deprecated Use CashDonationController::store() instead
     */
    public function processCashDonation()
    {
        return redirect()->route('donor.donations.cash.process');
    }

    /**
     * @deprecated Use FoodDonationController::create() instead
     */
    public function showFoodDonationForm()
    {
        return redirect()->route('donor.donations.food.index');
    }

    /**
     * @deprecated Use FoodDonationController::store() instead
     */
    public function processFoodDonation()
    {
        return redirect()->route('donor.donations.food.process');
    }
    
    /**
     * Process the clothing donation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processClothingDonation(Request $request)
    {
        $validated = $request->validate([
            'clothing_type' => 'required|array|min:1',
            'clothing_type.*' => 'string|in:shirts,pants,jackets,underwear,footwear,other',
            'other_clothing' => 'required_if:clothing_type,other|string|max:255|nullable',
            'gender' => 'required|in:unisex,men,women,children',
            'size' => 'required|in:xs,s,m,l,xl,xxl,xxxl,child',
            'condition' => 'required|in:new,excellent,good,fair',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'delivery_method' => 'required|in:pickup,pickup_arranged',
            'pickup_date' => 'required_if:delivery_method,pickup_arranged|date|after:today',
            'pickup_time' => 'required_if:delivery_method,pickup_arranged|in:morning,afternoon',
            'pickup_address' => 'required_if:delivery_method,pickup_arranged|string|max:500',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'message' => 'nullable|string|max:1000',
            'terms' => 'required|accepted',
        ]);
        
        // Process the clothing donation
        $donationData = [
            'type' => Donation::TYPE_CLOTHING,
            'clothing_types' => $validated['clothing_type'],
            'other_clothing_type' => $validated['other_clothing'] ?? null,
            'gender' => $validated['gender'],
            'size' => $validated['size'],
            'condition' => $validated['condition'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'] ?? null,
            'delivery_method' => $validated['delivery_method'],
            'pickup_date' => $validated['pickup_date'] ?? null,
            'pickup_time' => $validated['pickup_time'] ?? null,
            'pickup_address' => $validated['pickup_address'] ?? null,
            'donor_name' => $validated['name'],
            'donor_email' => $validated['email'],
            'donor_phone' => $validated['phone'],
            'donor_address' => $validated['address'],
            'message' => $validated['message'] ?? null,
            'status' => Donation::STATUS_PENDING,
            'submitted_at' => now(),
        ];
        
        // Handle photo uploads
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('donations/clothing/photos', 'public');
                $photoPaths[] = $path;
            }
            $donationData['photo_paths'] = $photoPaths;
        }
        
        // Save to database
        $donation = Donation::create($donationData);
        
        // Send notifications
        $this->sendDonationNotifications($donation);

        return redirect()->route('donor.donate.thank-you')->with([
            'success' => 'Thank you for your clothing donation!',
            'donation_type' => 'clothing',
            'quantity' => $validated['quantity'] . ' items',
            'clothing_types' => implode(', ', $validated['clothing_type'])
        ]);
    }
    
    /**
     * Process the medicine donation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processMedicineDonation(Request $request)
    {
        $validated = $request->validate([
            'medicine_type' => 'required|in:prescription,otc',
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
            'form' => 'required|string|in:tablet,capsule,syrup,injection,ointment,drops,inhaler,other',
            'other_form' => 'required_if:form,other|string|max:255|nullable',
            'expiry_date' => 'required|date|after:today',
            'description' => 'nullable|string|max:1000',
            'prescription_file' => 'required_if:medicine_type,prescription|file|mimes:jpeg,png,pdf|max:5120',
            'delivery_method' => 'required|in:pickup,pickup_arranged',
            'pickup_date' => 'required_if:delivery_method,pickup_arranged|date|after:today',
            'pickup_time' => 'required_if:delivery_method,pickup_arranged|in:morning,afternoon',
            'pickup_address' => 'required_if:delivery_method,pickup_arranged|string|max:500',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'message' => 'nullable|string|max:1000',
            'terms' => 'required|accepted',
        ]);
        
        // Process the medicine donation
        $donationData = [
            'type' => Donation::TYPE_MEDICINE,
            'medicine_type' => $validated['medicine_type'],
            'medicine_name' => $validated['medicine_name'],
            'dosage' => $validated['dosage'],
            'quantity' => $validated['quantity'],
            'form' => $validated['form'],
            'other_form' => $validated['other_form'] ?? null,
            'expiry_date' => $validated['expiry_date'],
            'description' => $validated['description'] ?? null,
            'delivery_method' => $validated['delivery_method'],
            'pickup_date' => $validated['pickup_date'] ?? null,
            'pickup_time' => $validated['pickup_time'] ?? null,
            'pickup_address' => $validated['pickup_address'] ?? null,
            'donor_name' => $validated['name'],
            'donor_email' => $validated['email'],
            'donor_phone' => $validated['phone'],
            'donor_address' => $validated['address'],
            'message' => $validated['message'] ?? null,
            'status' => Donation::STATUS_PENDING,
            'submitted_at' => now(),
        ];
        
        // Handle prescription file upload
        if ($request->hasFile('prescription_file')) {
            $path = $request->file('prescription_file')->store('donations/medicine/prescriptions', 'public');
            $donationData['prescription_path'] = $path;
        }
        
        // Save to database
        $donation = Donation::create($donationData);
        
        // Send notifications
        $this->sendDonationNotifications($donation);

        return redirect()->route('donor.donate.thank-you')->with([
            'success' => 'Thank you for your medicine donation!',
            'donation_type' => 'medicine',
            'item_name' => $validated['medicine_name'],
            'quantity' => $validated['quantity'] . ' ' . $validated['form']
        ]);
    }
    
    /**
     * Show the thank you page.
     *
     * @return \Illuminate\View\View
     */
    public function thankYou()
    {
        return view('donor.donate.thank-you');
    }

    /**
     * Show donation history.
     *
     * @return \Illuminate\View\View
     */
    public function donationHistory()
    {
        // Fetch donation history for the authenticated donor
        $donations = auth('donor')->user()->donations()
            ->with('donationItems')
            ->latest('created_at')
            ->paginate(10);
            
        return view('donor.donations.history', compact('donations'));
    }
    
    /**
     * Show a single donation.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\View\View
     */
    public function showDonation(Donation $donation)
    {
        // Ensure the donation belongs to the authenticated donor
        if ($donation->donor_id !== auth('donor')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Eager load relationships
        $donation->load('donationItems', 'activities');
        
        return view('donor.donations.show', compact('donation'));
    }
}

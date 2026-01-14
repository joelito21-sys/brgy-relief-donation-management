<?php

namespace App\Http\Controllers\Donor\Donation;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationHistoryController extends Controller
{
    /**
     * Display a listing of the donor's donations.
     */
    public function index()
    {
        $donations = Donation::where('donor_id', Auth::id())
            ->latest()
            ->paginate(10);

        // Check if the request is for the main donations index or history
        if (request()->route()->getName() === 'donor.donations.index') {
            // For the main donations index, use the new index view
            return view('donor.donations.index', [
                'donations' => $donations
            ]);
        } else {
            // For the history route, use the history view
            return view('donor.donations.history', [
                'donations' => $donations,
                'breadcrumbs' => [
                    ['label' => 'Donations', 'url' => route('donor.donations.index')],
                    ['label' => 'Donation History']
                ],
                'pageTitle' => 'My Donation History',
                'pageSubtitle' => 'View your donation history and receipts'
            ]);
        }
    }

    /**
     * Display the specified donation.
     */
    public function show(Donation $donation)
    {
        // Ensure the authenticated user owns this donation
        if ($donation->donor_id !== Auth::id()) {
            abort(403);
        }

        return view('donor.donations.show', [
            'donation' => $donation,
            'breadcrumbs' => [
                ['label' => 'Donations', 'url' => route('donor.donations.index')],
                ['label' => 'Donation #' . $donation->id]
            ],
            'pageTitle' => 'Donation Details',
            'pageSubtitle' => 'Donation #' . $donation->id
        ]);
    }

    /**
     * Show the thank you page after a successful donation.
     */
    public function thankYou(Donation $donation)
    {
        // Ensure the authenticated user owns this donation
        if ($donation->donor_id !== Auth::id()) {
            abort(403);
        }

        return view('donor.donations.thank-you', [
            'donation' => $donation,
            'breadcrumbs' => [
                ['label' => 'Donations', 'url' => route('donor.donations.index')],
                ['label' => 'Thank You']
            ],
            'pageTitle' => 'Thank You for Your Donation!',
            'pageSubtitle' => 'Your support makes a difference.'
        ]);
    }
}
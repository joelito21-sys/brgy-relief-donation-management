<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Beneficiary;
use DB;

class AboutController extends Controller
{
    /**
     * Display the about page with statistics
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalDonations = 0;
        $topDonor = null;
        $peopleHelped = 0;

        try {
            // Check if Donation model exists and has data
            if (class_exists(Donation::class)) {
                $totalDonations = Donation::sum('amount') ?? 0;
            }
            
            // Check if Donor model exists and has data
            if (class_exists(Donor::class) && class_exists(Donation::class)) {
                $topDonor = Donor::select('donors.name', DB::raw('SUM(donations.amount) as total'))
                    ->join('donations', 'donors.id', '=', 'donations.donor_id')
                    ->groupBy('donors.id', 'donors.name')
                    ->orderBy('total', 'DESC')
                    ->first();
            }
            
            // Check if Beneficiary model exists
            if (class_exists(Beneficiary::class)) {
                $peopleHelped = Beneficiary::count();
            }
        } catch (\Exception $e) {
            // Log the error but don't break the page
            \Log::error('Error loading about page data: ' . $e->getMessage());
        }
        
        return view('about', [
            'totalDonations' => $totalDonations,
            'topDonor' => $topDonor,
            'peopleHelped' => $peopleHelped,
        ]);
    }
}

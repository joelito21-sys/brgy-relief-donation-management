<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\ReliefRequest;
use App\Models\Resident;
use App\Models\Distribution;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $results = [];

        if ($query) {
            // Search donors
            $donors = Donor::where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('phone', 'LIKE', "%{$query}%")
                ->limit(5)
                ->get();

            // Search donations
            $donations = Donation::where('amount', 'LIKE', "%{$query}%")
                ->orWhere('reference_number', 'LIKE', "%{$query}%")
                ->orWhereHas('donor', function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->limit(5)
                ->get();

            // Search relief requests
            $reliefRequests = ReliefRequest::where('request_number', 'LIKE', "%{$query}%")
                ->orWhere('status', 'LIKE', "%{$query}%")
                ->orWhereHas('user', function ($q) use ($query) {
                    $q->where('first_name', 'LIKE', "%{$query}%")
                      ->orWhere('last_name', 'LIKE', "%{$query}%");
                })
                ->limit(5)
                ->get();

            // Search residents
            $residents = Resident::where('first_name', 'LIKE', "%{$query}%")
                ->orWhere('last_name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->limit(5)
                ->get();

            // Search distributions
            $distributions = Distribution::where('title', 'LIKE', "%{$query}%")
                ->orWhere('status', 'LIKE', "%{$query}%")
                ->limit(5)
                ->get();

            $results = [
                'donors' => $donors,
                'donations' => $donations,
                'relief_requests' => $reliefRequests,
                'residents' => $residents,
                'distributions' => $distributions,
            ];
        }

        return response()->json($results);
    }
}
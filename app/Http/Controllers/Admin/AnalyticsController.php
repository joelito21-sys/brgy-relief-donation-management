<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\ReliefRequest;
use App\Models\Distribution;
use App\Models\Resident;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Get data for the past 6 months
        $months = collect(range(6, 0))->map(function ($i) {
            return now()->subMonths($i)->format('M Y');
        });

        // Donations by month
        $donationsData = [];
        foreach (range(6, 0) as $i) {
            $date = now()->subMonths($i);
            $donationsData[] = Donation::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount') ?? 0;
        }

        // Requests by status
        $requestsByStatus = ReliefRequest::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Recent activities
        $recentActivities = DB::table('activity_log')
            ->latest()
            ->take(5)
            ->get();

        // Top donors
        $topDonors = Donation::with('donor')
            ->select('donor_id', DB::raw('SUM(amount) as total_donated'))
            ->groupBy('donor_id')
            ->orderByDesc('total_donated')
            ->take(5)
            ->get();

        return view('admin.analytics.index', [
            'months' => $months,
            'donationsData' => $donationsData,
            'requestsByStatus' => $requestsByStatus,
            'recentActivities' => $recentActivities,
            'topDonors' => $topDonors,
            'totalDonations' => Donation::sum('amount'),
            'pendingRequests' => ReliefRequest::where('status', 'pending')->count(),
            'completedDistributions' => Distribution::where('status', 'completed')->count(),
            'totalResidents' => Resident::count(),
        ]);
    }
}
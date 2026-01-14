<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Incident;
use App\Models\Resource;
use App\Models\ActivityLog;
use App\Models\Report;
use App\Models\Donation;
use App\Models\ReliefRequest;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_donors' => Donor::count(),
            'pending_requests' => ReliefRequest::where('status', 'pending')->count(),
            'pending_residents' => Resident::where('approval_status', 'pending')->count(),
            'total_residents' => Resident::count(),
            'approved_residents' => Resident::where('approval_status', 'approved')->count(),
            'rejected_residents' => Resident::where('approval_status', 'rejected')->count(),
            'total_donations' => [
                'cash' => Donation::where('type', 'cash')->sum('amount') ?? 0,
                'food' => Donation::where('type', 'food')->sum('quantity') ?? 0,
                'clothing' => Donation::where('type', 'clothing')->sum('quantity') ?? 0,
                'medical' => Donation::where('type', 'medical')->sum('quantity') ?? 0,
            ],
            'recent_donations' => Donation::with('donor')
                ->latest()
                ->take(5)
                ->get(),
            'donations_by_month' => $this->getDonationsByMonth(),
            'recent_residents' => Resident::orderBy('created_at', 'desc')
                ->take(6)
                ->get(),
            'pending_residents_list' => Resident::where('approval_status', 'pending')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            // Get walk-in appointments
            'walkin_appointments' => Donation::where('type', 'cash')
                ->where('payment_method', 'walkin')
                ->where('status', 'pending')
                ->with('donor')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
        ];

        // Get recent activities
        $recentActivities = ActivityLog::with('causer')
            ->latest()
            ->take(5)
            ->get();

        // Temporarily disabled reports functionality
        $urgentReports = collect([]); // Empty collection as fallback
        /*
        $urgentReports = Report::where('priority', 'high')
            ->with('reporter')
            ->latest()
            ->take(3)
            ->get();
        */

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'urgentReports' => $urgentReports,
        ]);
    }

    /**
     * Get donations data for the last 6 months for the chart
     *
     * @return array
     */
    protected function getDonationsByMonth()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
        
        $donations = Donation::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(CASE WHEN type = "cash" THEN amount ELSE 0 END) as cash'),
                DB::raw('SUM(CASE WHEN type != "cash" THEN quantity ELSE 0 END) as in_kind')
            )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $labels = [];
        $cashData = [];
        $inKindData = [];
        
        // Initialize data for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('M Y');
            $labels[] = $monthYear;
            $cashData[$monthYear] = 0;
            $inKindData[$monthYear] = 0;
        }

        // Fill in the actual data
        foreach ($donations as $donation) {
            $date = Carbon::createFromDate($donation->year, $donation->month, 1);
            $monthYear = $date->format('M Y');
            
            if (isset($cashData[$monthYear])) {
                $cashData[$monthYear] = (float) $donation->cash;
                $inKindData[$monthYear] = (int) $donation->in_kind;
            }
        }

        return [
            'labels' => $labels,
            'cash' => array_values($cashData),
            'in_kind' => array_values($inKindData),
        ];
    }
}

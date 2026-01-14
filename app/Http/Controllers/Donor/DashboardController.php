<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Donation;

class DashboardController extends Controller
{
    /**
     * Display the donor dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $donor = Auth::guard('donor')->user();
        
        // Get total donations amount (include cash and approved non-cash donations)
        $totalDonations = $donor->donations()
            ->where(function($query) {
                $query->where('status', 'approved')
                      ->orWhere('status', 'completed');
            })
            ->sum('amount');
            
        // Get donation statistics
        $donationCount = $donor->donations()->count();
        $donationStats = [
            'total' => $donationCount,
            'approved' => $donor->donations()->where('status', 'approved')->count(),
            'pending' => $donor->donations()->where('status', 'pending')->count(),
            'rejected' => $donor->donations()->where('status', 'rejected')->count(),
            'completed' => $donor->donations()->where('status', 'completed')->count(),
        ];
        
        // Get recent donations (last 5)
        $recentDonations = $donor->donations()
            ->with('donor')
            ->latest('created_at')
            ->limit(5)
            ->get();
            
        // Get recent activities (donations and updates)
        $recentActivities = $donor->donations()
            ->select('id', 'type', 'status', 'amount', 'created_at', 'updated_at')
            ->with('donor')
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->map(function($donation) {
                $description = '';
                if ($donation->type === 'cash') {
                    $description = 'Cash donation of ₱' . number_format($donation->amount, 2) . ' was ' . $donation->status;
                } else {
                    $description = ucfirst($donation->type) . ' donation was ' . $donation->status;
                }
                
                return [
                    'type' => 'donation',
                    'title' => ucfirst($donation->type) . ' Donation ' . ucfirst($donation->status),
                    'description' => $description,
                    'date' => $donation->updated_at,
                    'icon' => $this->getActivityIcon($donation->status),
                    'color' => $this->getStatusColor($donation->status)
                ];
            });
            
        // Get upcoming events (sample data - replace with actual events)
        $upcomingEvents = [
            [
                'title' => 'Flood Relief Fundraiser',
                'date' => now()->addDays(5),
                'location' => 'Community Center',
                'description' => 'Annual fundraiser for flood relief efforts'
            ],
            [
                'title' => 'Volunteer Training',
                'date' => now()->addDays(10),
                'location' => 'Online',
                'description' => 'Training session for new volunteers'
            ]
        ];
        
        // Get impact metrics (sample data - replace with actual metrics)
        $impactMetrics = [
            'families_helped' => 125,
            'meals_provided' => 2500,
            'clothing_items' => 500,
            'medical_kits' => 75
        ];
        
        // Calculate donation goal progress (sample goal of $10,000)
        $donationGoal = 10000;
        $progress = min(round(($totalDonations / $donationGoal) * 100), 100);
        
        return view('donor.dashboard', compact(
            'totalDonations',
            'donationCount',
            'donationStats',
            'recentDonations',
            'recentActivities',
            'upcomingEvents',
            'impactMetrics',
            'progress',
            'donationGoal'
        ));
    }
    
    /**
     * Get the appropriate icon for an activity based on status
     * 
     * @param string $status
     * @return string
     */
    private function getActivityIcon($status)
    {
        switch ($status) {
            case 'completed':
                return 'check-circle';
            case 'pending':
                return 'clock';
            case 'cancelled':
                return 'x-circle';
            default:
                return 'info';
        }
    }
    
    /**
     * Get the appropriate color for a status
     * 
     * @param string $status
     * @return string
     */
    private function getStatusColor($status)
    {
        switch ($status) {
            case 'completed':
                return 'success';
            case 'approved':
                return 'success';
            case 'pending':
                return 'warning';
            case 'rejected':
                return 'danger';
            case 'cancelled':
                return 'danger';
            default:
                return 'info';
        }
    }
}

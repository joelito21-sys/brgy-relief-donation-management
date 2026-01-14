<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:resident');
    }

    /**
     * Display the resident dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $resident = Auth::guard('resident')->user();

        // Get resident's relief requests (if table exists)
        $reliefRequests = Schema::hasTable('relief_requests')
            ? $resident->reliefRequests()->with(['items', 'distribution'])->latest()->limit(5)->get()
            : collect();

        // Get statistics (if table exists)
        $stats = Schema::hasTable('relief_requests')
            ? [
                'total_requests' => $resident->reliefRequests()->count(),
                'pending_requests' => $resident->reliefRequests()->where('status', 'pending')->count(),
                'approved_requests' => $resident->reliefRequests()->where('status', 'approved')->count(),
                'completed_requests' => $resident->reliefRequests()->where('status', 'completed')->count(),
                'total_received_items' => $this->getTotalReceivedItems($resident),
            ]
            : [
                'total_requests' => 0,
                'pending_requests' => 0,
                'approved_requests' => 0,
                'completed_requests' => 0,
                'total_received_items' => 0,
            ];

        // Get recent activities (if table exists)
        $recentActivities = Schema::hasTable('relief_requests')
            ? $resident->reliefRequests()
                ->select('id', 'status', 'created_at', 'updated_at')
                ->latest('updated_at')
                ->limit(5)
                ->get()
                ->map(function($request) {
                    return [
                        'type' => 'relief_request',
                        'title' => 'Relief Request ' . ucfirst($request->status),
                        'description' => 'Request #' . $request->id . ' was ' . $request->status,
                        'date' => $request->updated_at,
                        'icon' => $this->getActivityIcon($request->status),
                        'color' => $this->getStatusColor($request->status)
                    ];
                })
            : collect();

        // Get evacuation status (if column exists)
        $evacuationStatus = Schema::hasColumn('residents', 'evacuation_status') ? $resident->evacuation_status : false;
        $evacuationInfo = $this->getEvacuationInfo($resident);

        return view('resident.dashboard', compact(
            'resident',
            'reliefRequests',
            'stats',
            'recentActivities',
            'evacuationStatus',
            'evacuationInfo'
        ));
    }

    /**
     * Get activity icon based on status
     */
    private function getActivityIcon($status)
    {
        return match($status) {
            'pending' => 'fas fa-clock',
            'approved' => 'fas fa-check-circle',
            'rejected' => 'fas fa-times-circle',
            'completed' => 'fas fa-check-double',
            default => 'fas fa-info-circle'
        };
    }

    /**
     * Get status color
     */
    private function getStatusColor($status)
    {
        return match($status) {
            'pending' => 'yellow',
            'approved' => 'blue',
            'rejected' => 'red',
            'completed' => 'green',
            default => 'gray'
        };
    }

    /**
     * Get evacuation information
     */
    private function getEvacuationInfo($resident)
    {
        if (!$resident->evacuation_status) {
            return [
                'status' => 'safe',
                'message' => 'You are currently at home. Stay safe and monitor updates.',
                'action' => 'Stay informed and be ready to evacuate if needed.'
            ];
        }

        return [
            'status' => 'evacuated',
            'message' => 'You are currently in an evacuation center.',
            'action' => 'Please follow evacuation center guidelines and stay in touch with authorities.'
        ];
    }

    /**
     * Get total received items for a resident
     */
    private function getTotalReceivedItems($resident)
    {
        try {
            if (!Schema::hasTable('distributions') || !Schema::hasTable('relief_requests')) {
                return 0;
            }
            
            return $resident->receivedDonations()->count();
        } catch (\Exception $e) {
            // Log the error if needed, but return 0 to prevent page crash
            return 0;
        }
    }
}

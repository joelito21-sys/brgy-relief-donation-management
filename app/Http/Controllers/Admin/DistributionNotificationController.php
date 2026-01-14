<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistributionNotification;
use App\Models\Distribution;
use App\Models\ReliefRequest;
use App\Models\Resident;
use App\Notifications\DistributionNotification as DistributionNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionNotificationController extends Controller
{
    /**
     * Display a listing of distribution notifications.
     */
    public function index()
    {
        $notifications = DistributionNotification::with(['distribution', 'reliefRequest', 'sentBy'])
            ->latest()
            ->paginate(10);

        return view('admin.distribution-notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new distribution notification.
     */
    public function create()
    {
        $distributions = Distribution::where('status', 'scheduled')->get();
        $reliefRequests = ReliefRequest::where('status', 'approved')->get();
        
        // Get resident counts per Purok
        $purokCounts = [];
        for ($i = 1; $i <= 10; $i++) {
            $purokName = "Purok $i";
            $purokCounts[$purokName] = Resident::where('approval_status', 'approved')
                ->where('address', 'like', "%$purokName%")
                ->count();
        }
        
        $totalApprovedResidents = Resident::where('approval_status', 'approved')->count();
        
        return view('admin.distribution-notifications.create', compact('distributions', 'reliefRequests', 'purokCounts', 'totalApprovedResidents'));
    }

    /**
     * Store a newly created distribution notification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'distribution_type' => 'required|in:general,specific',
            'distribution_id' => 'nullable|exists:distributions,id',
            'relief_request_id' => 'nullable|exists:relief_requests,id',
            'location' => 'required|string|max:255',
            'scheduled_date' => 'required|date|after:now',
            'target_area' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'send_immediately' => 'boolean',
        ]);

        $distributionNotification = DistributionNotification::create([
            'title' => $request->title,
            'message' => $request->message,
            'distribution_type' => $request->distribution_type,
            'distribution_id' => $request->distribution_id,
            'relief_request_id' => $request->relief_request_id,
            'location' => $request->location,
            'scheduled_date' => $request->scheduled_date,
            'target_area' => $request->target_area,
            'additional_info' => $request->additional_info,
            'sent_by' => Auth::guard('admin')->id(),
        ]);

        if ($request->send_immediately) {
            $this->sendNotification($distributionNotification);
        }

        return redirect()
            ->route('admin.distribution-notifications.index')
            ->with('success', 'Distribution notification created successfully.');
    }

    /**
     * Display the specified distribution notification.
     */
    public function show(DistributionNotification $distributionNotification)
    {
        $distributionNotification->load(['distribution', 'reliefRequest', 'sentBy']);
        
        return view('admin.distribution-notifications.show', compact('distributionNotification'));
    }

    /**
     * Send the distribution notification to residents.
     */
    public function send(DistributionNotification $distributionNotification)
    {
        if ($distributionNotification->is_sent) {
            return redirect()
                ->back()
                ->with('error', 'This notification has already been sent.');
        }

        $this->sendNotification($distributionNotification);

        return redirect()
            ->back()
            ->with('success', 'Notification sent successfully to all residents.');
    }

    /**
     * Send notification to relevant residents.
     */
    private function sendNotification(DistributionNotification $distributionNotification)
    {
        $residents = $this->getTargetResidents($distributionNotification);
        
        foreach ($residents as $resident) {
            // Create a confirmation record with unique QR code
            $confirmation = \App\Models\DistributionConfirmation::firstOrCreate(
                [
                    'distribution_notification_id' => $distributionNotification->id,
                    'resident_id' => $resident->id,
                ],
                [
                    'qr_code' => \App\Models\DistributionConfirmation::generateUniqueQrCode(),
                ]
            );
            
            // Send notification with QR code
            $resident->notify(new DistributionNotificationMail($distributionNotification, $confirmation));
        }

        $distributionNotification->update([
            'is_sent' => true,
            'sent_at' => now(),
        ]);
    }

    /**
     * Get target residents based on distribution type.
     */
    private function getTargetResidents(DistributionNotification $distributionNotification)
    {
        if ($distributionNotification->distribution_type === 'specific') {
            // For specific distributions, notify the resident who made the relief request
            if ($distributionNotification->reliefRequest) {
                return Resident::where('id', $distributionNotification->reliefRequest->user_id)->get();
            }
        } else {
            // For general distributions, notify all approved residents in the target area
            $query = Resident::where('approval_status', 'approved');
            
            if ($distributionNotification->target_area) {
                $query->where('address', 'like', '%' . $distributionNotification->target_area . '%');
            }
            
            return $query->get();
        }

        return collect([]);
    }

    /**
     * Remove the specified distribution notification.
     */
    public function destroy(DistributionNotification $distributionNotification)
    {
        if ($distributionNotification->is_sent) {
            return redirect()
                ->back()
                ->with('error', 'Cannot delete a notification that has already been sent.');
        }

        $distributionNotification->delete();

        return redirect()
            ->route('admin.distribution-notifications.index')
            ->with('success', 'Distribution notification deleted successfully.');
    }
}

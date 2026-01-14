<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistributionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QRScannerController extends Controller
{
    /**
     * Display the QR scanner page.
     */
    public function index()
    {
        return view('admin.scanner.index');
    }

    /**
     * Verify a QR code and return resident information.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string|max:64',
        ]);

        $qrCode = strtoupper(trim($request->qr_code));
        
        $confirmation = DistributionConfirmation::with(['resident', 'distributionNotification', 'confirmedBy'])
            ->where('qr_code', $qrCode)
            ->first();

        if (!$confirmation) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid QR code. This code is not registered in the system.',
            ], 404);
        }

        if ($confirmation->isConfirmed()) {
            return response()->json([
                'success' => false,
                'already_confirmed' => true,
                'message' => 'This relief package has already been claimed.',
                'data' => [
                    'resident_name' => $confirmation->resident->name,
                    'confirmed_at' => $confirmation->confirmed_at->format('F j, Y g:i A'),
                    'confirmed_by' => $confirmation->confirmedBy ? $confirmation->confirmedBy->name : 'Unknown',
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'QR code verified successfully.',
            'data' => [
                'confirmation_id' => $confirmation->id,
                'resident_name' => $confirmation->resident->name,
                'resident_address' => $confirmation->resident->address,
                'resident_phone' => $confirmation->resident->phone,
                'distribution_title' => $confirmation->distributionNotification->title,
                'distribution_location' => $confirmation->distributionNotification->location,
                'scheduled_date' => $confirmation->distributionNotification->formatted_scheduled_date,
                'family_members' => $confirmation->resident->family_members ?? 1,
            ],
        ]);
    }

    /**
     * Confirm that a resident has received their relief package.
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'confirmation_id' => 'required|integer|exists:distribution_confirmations,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $confirmation = DistributionConfirmation::findOrFail($request->confirmation_id);

        if ($confirmation->isConfirmed()) {
            return response()->json([
                'success' => false,
                'message' => 'This relief package has already been claimed.',
            ], 400);
        }

        $confirmation->confirm(Auth::guard('admin')->id(), $request->notes);

        return response()->json([
            'success' => true,
            'message' => 'Relief package confirmed as received!',
            'data' => [
                'resident_name' => $confirmation->resident->name,
                'confirmed_at' => $confirmation->confirmed_at->format('F j, Y g:i A'),
            ],
        ]);
    }

    /**
     * Show confirmation statistics for a distribution notification.
     */
    public function stats($notificationId)
    {
        $confirmations = DistributionConfirmation::where('distribution_notification_id', $notificationId)
            ->with('resident')
            ->get();

        $total = $confirmations->count();
        $confirmed = $confirmations->where('confirmed_at', '!=', null)->count();
        $pending = $total - $confirmed;

        return response()->json([
            'total' => $total,
            'confirmed' => $confirmed,
            'pending' => $pending,
            'percentage' => $total > 0 ? round(($confirmed / $total) * 100) : 0,
        ]);
    }
}

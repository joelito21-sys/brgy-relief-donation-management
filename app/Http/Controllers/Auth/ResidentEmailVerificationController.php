<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\VerificationOtp;
use App\Mail\OtpNotification; // Updated class name
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class ResidentEmailVerificationController extends Controller
{
    /**
     * Show the email verification form.
     */
    public function show()
    {
        // Check if resident has pending verification
        $residentId = session('resident_id');
        if (!$residentId) {
            return redirect()->route('resident.register')
                ->with('error', 'Please register first.');
        }

        $resident = Resident::find($residentId);
        if (!$resident) {
            return redirect()->route('resident.register')
                ->with('error', 'Registration session expired. Please register again.');
        }

        // If already verified, redirect to login
        if ($resident->email_verified_at) {
            return redirect()->route('resident.login')
                ->with('status', 'Your email is already verified. Please login.');
        }

        return view('resident.auth.verify-email', ['resident' => $resident]);
    }

    /**
     * Verify the OTP and mark email as verified.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $residentId = session('resident_id');
        if (!$residentId) {
            return back()->with('error', 'Session expired. Please register again.');
        }

        $resident = Resident::find($residentId);
        if (!$resident) {
            return back()->with('error', 'User not found. Please register again.');
        }

        // Find the OTP record
        $verificationOtp = VerificationOtp::where('user_id', $residentId)
            ->where('user_type', 'resident')
            ->first();

        if (!$verificationOtp) {
            return back()->with('error', 'Verification code not found or expired.');
        }

        // Verify the OTP
        if (!$verificationOtp->isValid($request->otp)) {
            return back()->with('error', 'Invalid or expired verification code.');
        }

        // Mark email as verified
        $resident->email_verified_at = now();
        $resident->save();

        // Delete the OTP record
        $verificationOtp->delete();

        // Clear session
        session()->forget(['resident_otp', 'resident_id']);

        // Log the user in
        Auth::guard('resident')->login($resident);

        return redirect()->route('resident.verification')
            ->with('status', 'Email verified successfully! Your account is now awaiting admin approval.');
    }

    /**
     * Resend OTP.
     */
    public function resend(Request $request)
    {
        $residentId = session('resident_id');
        if (!$residentId) {
            return back()->with('error', 'Session expired. Please register again.');
        }

        $resident = Resident::find($residentId);
        if (!$resident) {
            return back()->with('error', 'User not found. Please register again.');
        }

        // Generate new OTP
        $otp = VerificationOtp::generateOtpForUser($residentId, 'resident');
        
        if ($otp) {
            try {
                // Send OTP email
                Mail::to($resident->email)->send(new OtpNotification($resident, $otp->plain_otp, 'resident'));
                
                // Store OTP in session for development/debug
                session(['resident_otp' => $otp->plain_otp]);
                
                return back()->with('status', 'Verification code sent to your email.')
                    ->with('debug_otp', $otp->plain_otp); // Remove this line in production
            } catch (\Exception $e) {
                \Log::error('Failed to resend OTP email: ' . $e->getMessage());
                
                // Store OTP in session for fallback
                session(['resident_otp' => $otp->plain_otp]);
                
                return back()->with('status', 'Verification code sent to your email.')
                    ->with('debug_otp', $otp->plain_otp)
                    ->with('warning', 'Email service unavailable. Please use the debug code for testing.');
            }
        }

        return back()->with('error', 'Failed to send verification code. Please try again.');
    }
}
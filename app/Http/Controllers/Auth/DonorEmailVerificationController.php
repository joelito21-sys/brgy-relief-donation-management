<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\VerificationOtp;
use App\Mail\OtpNotification; // Updated class name
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DonorEmailVerificationController extends Controller
{
    /**
     * Show the email verification form.
     */
    public function show()
    {
        // Check if donor has pending verification
        $donorId = session('donor_id');
        if (!$donorId) {
            return redirect()->route('donor.register')
                ->with('error', 'Please register first.');
        }

        $donor = Donor::find($donorId);
        if (!$donor) {
            return redirect()->route('donor.register')
                ->with('error', 'Registration session expired. Please register again.');
        }

        // If already verified, redirect to login
        if ($donor->email_verified_at) {
            return redirect()->route('donor.login')
                ->with('status', 'Your email is already verified. Please login.');
        }

        return view('donor.auth.verify-email', ['donor' => $donor]);
    }

    /**
     * Verify the OTP and mark email as verified.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $donorId = session('donor_id');
        if (!$donorId) {
            return back()->with('error', 'Session expired. Please register again.');
        }

        $donor = Donor::find($donorId);
        if (!$donor) {
            return back()->with('error', 'User not found. Please register again.');
        }

        // Find the OTP record
        $verificationOtp = VerificationOtp::where('user_id', $donorId)
            ->where('user_type', 'donor')
            ->first();

        if (!$verificationOtp) {
            return back()->with('error', 'Verification code not found or expired.');
        }

        // Verify the OTP
        if (!$verificationOtp->isValid($request->otp)) {
            return back()->with('error', 'Invalid or expired verification code.');
        }

        // Mark email as verified
        $donor->email_verified_at = now();
        $donor->save();

        // Delete the OTP record
        $verificationOtp->delete();

        // Clear session
        session()->forget(['donor_otp', 'donor_id']);

        // Log the user in
        Auth::guard('donor')->login($donor);

        return redirect()->route('donor.dashboard')
            ->with('status', 'Email verified successfully! Welcome to your dashboard.');
    }

    /**
     * Resend OTP.
     */
    public function resend(Request $request)
    {
        $donorId = session('donor_id');
        if (!$donorId) {
            return back()->with('error', 'Session expired. Please register again.');
        }

        $donor = Donor::find($donorId);
        if (!$donor) {
            return back()->with('error', 'User not found. Please register again.');
        }

        // Generate new OTP
        $otp = VerificationOtp::generateOtpForUser($donorId, 'donor');
        
        if ($otp) {
            try {
                // Send OTP email
                Mail::to($donor->email)->send(new OtpNotification($donor, $otp->plain_otp, 'donor'));
                
                // Store OTP in session for development/debug
                session(['donor_otp' => $otp->plain_otp]);
                
                return back()->with('status', 'Verification code sent to your email.')
                    ->with('debug_otp', $otp->plain_otp); // Remove this line in production
            } catch (\Exception $e) {
                \Log::error('Failed to resend OTP email: ' . $e->getMessage());
                
                // Store OTP in session for fallback
                session(['donor_otp' => $otp->plain_otp]);
                
                return back()->with('status', 'Verification code sent to your email.')
                    ->with('debug_otp', $otp->plain_otp)
                    ->with('warning', 'Email service unavailable. Please use the debug code for testing.');
            }
        }

        return back()->with('error', 'Failed to send verification code. Please try again.');
    }
}
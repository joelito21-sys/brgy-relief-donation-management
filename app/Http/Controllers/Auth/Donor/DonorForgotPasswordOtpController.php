<?php

namespace App\Http\Controllers\Auth\Donor;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\VerificationOtp;
use App\Notifications\DonorResetPasswordOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DonorForgotPasswordOtpController extends Controller
{
    /**
     * Display the form to request a password reset OTP.
     */
    public function showLinkRequestForm()
    {
        return view('donor.auth.passwords.otp-request');
    }

    /**
     * Handle the request to send an OTP.
     */
    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $email = trim($request->email);
        $donor = Donor::where('email', $email)->first();

        if (!$donor) {
            return back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
        }

        // Generate OTP
        $otp = VerificationOtp::generateOtpForUser($donor->id, 'donor');

        // Send OTP Notification
        $donor->notify(new DonorResetPasswordOtpNotification($otp->plain_otp));

        // Store email in session to carry over to the verify page
        session(['reset_donor_email' => $email]);

        return redirect()->route('donor.password.otp.verify');
    }

    /**
     * Display the OTP verification form.
     */
    public function showVerifyOtpForm()
    {
        if (!session('reset_donor_email')) {
            return redirect()->route('donor.password.request');
        }

        return view('donor.auth.passwords.otp-verify');
    }

    /**
     * Verify the OTP and redirect to reset password page.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $email = session('reset_donor_email');
        if (!$email) {
            return redirect()->route('donor.password.request');
        }

        $donor = Donor::where('email', $email)->first();
        if (!$donor) {
             return redirect()->route('donor.password.request')->withErrors(['email' => 'User not found.']);
        }

        $otpRecord = VerificationOtp::where('user_id', $donor->id)
            ->where('user_type', 'donor')
            ->first();

        if (!$otpRecord || !$otpRecord->isValid($request->otp)) {
            return back()->withErrors(['otp' => 'The provided OTP is invalid or has expired.']);
        }

        // OTP is valid. Store a flag in session to allow password reset
        session(['otp_verified_donor_id' => $donor->id]);
        
        // Clean up used OTP
        $otpRecord->delete();

        return redirect()->route('donor.password.reset.form');
    }
    
     /**
     * Display the password reset form (after OTP verification).
     */
    public function showResetForm()
    {
        if (!session('otp_verified_donor_id')) {
            return redirect()->route('donor.password.request');
        }
        
        return view('donor.auth.passwords.reset-with-otp');
    }
    
    /**
     * Reset the password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);
        
        $donorId = session('otp_verified_donor_id');
        if (!$donorId) {
             return redirect()->route('donor.password.request');
        }
        
        $donor = Donor::find($donorId);
        if (!$donor) {
             return redirect()->route('donor.password.request');
        }
        
        // Update password
        $donor->password = Hash::make($request->password);
        $donor->save();
        
        // Clear session
        session()->forget(['reset_donor_email', 'otp_verified_donor_id']);
        
        return redirect()->route('donor.login')->with('status', 'Your password has been reset!');
    }
}

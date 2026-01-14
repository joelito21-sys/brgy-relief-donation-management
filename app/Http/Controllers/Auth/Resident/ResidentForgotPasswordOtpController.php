<?php

namespace App\Http\Controllers\Auth\Resident;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\VerificationOtp;
use App\Notifications\ResidentResetPasswordOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResidentForgotPasswordOtpController extends Controller
{
    /**
     * Display the form to request a password reset OTP.
     */
    public function showLinkRequestForm()
    {
        return view('resident.auth.passwords.otp-request');
    }

    /**
     * Handle the request to send an OTP.
     */
    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $email = trim($request->email);
        \Log::info('Resident OTP Request for email: ' . $email);

        $resident = Resident::where('email', $email)->first();

        if (!$resident) {
            \Log::warning('Resident not found for email: ' . $email);
            // Debug: check if any resident exists similar
            $similar = Resident::where('email', 'like', "%{$email}%")->first();
            if ($similar) {
                 \Log::info('Found similar email: ' . $similar->email);
            }
            
            return back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
        }

        // Generate OTP
        $otp = VerificationOtp::generateOtpForUser($resident->id, 'resident');

        // Send OTP Notification
        $resident->notify(new ResidentResetPasswordOtpNotification($otp->plain_otp));

        // Store email in session to carry over to the verify page
        session(['reset_email' => $request->email]);

        return redirect()->route('resident.password.otp.verify');
    }

    /**
     * Display the OTP verification form.
     */
    public function showVerifyOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('resident.password.request');
        }

        return view('resident.auth.passwords.otp-verify');
    }

    /**
     * Verify the OTP and redirect to reset password page.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('resident.password.request');
        }

        $resident = Resident::where('email', $email)->first();
        if (!$resident) {
             return redirect()->route('resident.password.request')->withErrors(['email' => 'User not found.']);
        }

        $otpRecord = VerificationOtp::where('user_id', $resident->id)
            ->where('user_type', 'resident')
            ->first();

        if (!$otpRecord || !$otpRecord->isValid($request->otp)) {
            return back()->withErrors(['otp' => 'The provided OTP is invalid or has expired.']);
        }

        // OTP is valid. Store a flag in session to allow password reset
        session(['otp_verified_resident_id' => $resident->id]);
        
        // Clean up used OTP
        $otpRecord->delete();

        return redirect()->route('resident.password.reset.form');
    }
    
     /**
     * Display the password reset form (after OTP verification).
     */
    public function showResetForm()
    {
        if (!session('otp_verified_resident_id')) {
            return redirect()->route('resident.password.request');
        }
        
        return view('resident.auth.passwords.reset-with-otp');
    }
    
    /**
     * Reset the password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);
        
        $residentId = session('otp_verified_resident_id');
        if (!$residentId) {
             return redirect()->route('resident.password.request');
        }
        
        $resident = Resident::find($residentId);
        if (!$resident) {
             return redirect()->route('resident.password.request');
        }
        
        // Update password
        $resident->password = $request->password;
        $resident->save();
        
        // Clear session
        session()->forget(['reset_email', 'otp_verified_resident_id']);
        
        return redirect()->route('resident.login')->with('status', 'Your password has been reset!');
    }
}

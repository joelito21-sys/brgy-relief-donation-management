<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.verify-email');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return back()->with('error', 'User not found. Please log in again.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        // Determine user type and query OTP
        $userType = 'user';
        $verificationOtp = VerificationOtp::where('user_id', $user->id)
                                          ->where('user_type', $userType)
                                          ->first();

        if (!$verificationOtp || !$verificationOtp->isValid($request->otp)) {
            return back()->with('error', 'The verification code is invalid or has expired.');
        }

        // Mark email as verified
        $user->markEmailAsVerified();

        // Delete the used OTP
        $verificationOtp->delete();

        return redirect($this->redirectPath())->with('status', 'Email verified successfully!');
    }

    public function resend(Request $request)
    {
        $user = $request->user();
        
        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $this->sendVerificationOtp($user);

        return back()->with('status', 'A new verification code has been sent to your email.');
    }

    protected function sendVerificationOtp($user)
    {
        try {
            $userType = 'user';
            $verificationOtp = VerificationOtp::generateOtpForUser($user->id, $userType);
            $plainOtp = $verificationOtp->plain_otp;
            
            $user->notify(new \App\Notifications\VerifyEmailOtp($plainOtp));
        } catch (\Exception $e) {
            Log::error('Failed to send verification OTP: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function redirectPath()
    {
        $user = Auth::user();
        return '/donor/dashboard';
    }
}

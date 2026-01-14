<?php

namespace App\Http\Controllers\Auth;

use App\Models\Donor;
use App\Models\VerificationOtp;
use App\Mail\DonorOtpNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Features;
use Illuminate\Validation\Rules\Password;

class DonorRegisteredUserController extends Controller
{
    /**
     * Show the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('donor.auth.register', ['guard' => 'donor']);
    }

    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\CreatesNewUsers  $creator
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:donors',
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $donor = Donor::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $request->address,
            // Remove auto-verification - email_verified_at will be null
        ]);

        // Fire the registered event
        event(new Registered($donor));

        // Generate and send OTP
        $otp = VerificationOtp::generateOtpForUser($donor->id, 'donor');
        
        if ($otp) {
            try {
                // Send OTP email
                Mail::to($donor->email)->send(new DonorOtpNotification($donor, $otp->plain_otp));
                // \Log::info('Skipping email sending: DonorOtpNotification class missing.');
                
                // Store OTP in session for development/debug
                session(['donor_otp' => $otp->plain_otp, 'donor_id' => $donor->id]);
                
                return redirect()->route('donor.verification.show')
                    ->with('status', 'Registration successful! Please check your email for verification code.')
                    ->with('debug_otp', $otp->plain_otp); // Remove this line in production
            } catch (\Exception $e) {
                \Log::error('Failed to send OTP email: ' . $e->getMessage());
                
                // Store OTP in session for fallback
                session(['donor_otp' => $otp->plain_otp, 'donor_id' => $donor->id]);
                
                return redirect()->route('donor.verification.show')
                    ->with('status', 'Registration successful! Please check your email for verification code.')
                    ->with('debug_otp', $otp->plain_otp)
                    ->with('warning', 'Email service unavailable. Please use the debug code for testing.');
            }
        }

        return redirect()->route('donor.verification.show')
            ->with('status', 'Registration successful! Please check your email for verification code.');
    }
}

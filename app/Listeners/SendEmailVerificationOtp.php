<?php

namespace App\Listeners;

use App\Models\VerificationOtp;
use App\Notifications\VerifyEmailOtp;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class SendEmailVerificationOtp
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        // Skip OTP for residents; they will be handled via admin review instead
        if ($user instanceof \App\Models\Resident) {
            Log::info('Skipping email OTP for resident registration', ['resident_id' => $user->id]);
            return;
        }

        try {
            // Ensure the user is saved to the database before generating OTP
            if (!$user->exists) {
                Log::error('Cannot generate OTP: User not saved to database', ['user_id' => $user->id]);
                return;
            }

            // Detect user type based on model class
            $userType = 'user';
            if ($user instanceof \App\Models\Resident) {
                $userType = 'resident';
            } elseif ($user instanceof \App\Models\Donor) {
                $userType = 'donor';
            } elseif ($user instanceof \App\Models\Admin) {
                $userType = 'admin';
            }
            
            // Generate OTP; may return null if underlying record cannot be verified
            $verificationOtp = VerificationOtp::generateOtpForUser($user->id, $userType);

            if ($verificationOtp === null) {
                Log::warning('OTP generation skipped; verificationOtp is null', [
                    'user_id' => $user->id,
                    'user_type' => $userType,
                ]);
                return;
            }

            // Get the plain OTP from the temporary property
            $plainOtp = $verificationOtp->plain_otp ?? null;
            if ($plainOtp === null) {
                Log::warning('OTP record created but plain_otp is missing', [
                    'user_id' => $user->id,
                    'user_type' => $userType,
                ]);
                return;
            }

            $user->notify(new VerifyEmailOtp($plainOtp));
            
            Log::info('OTP generated and sent successfully', [
                'user_id' => $user->id,
                'user_type' => $userType,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send verification OTP: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'exception' => $e
            ]);
            
            // Re-throw the exception to let Laravel handle it
            throw $e;
        }
    }
}

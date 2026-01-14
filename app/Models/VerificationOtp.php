<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class VerificationOtp extends Model
{
    protected $fillable = [
        'user_id',
        'user_type',
        'otp',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function generateOtpForUser($userId, $userType = 'user')
    {
        // First, verify the user exists in the appropriate table
        $exists = false;

        switch ($userType) {
            case 'user':
                $exists = \App\Models\User::where('id', $userId)->exists();
                break;
            case 'resident':
                $exists = class_exists(\App\Models\Resident::class)
                    ? \App\Models\Resident::where('id', $userId)->exists()
                    : false;
                break;
            case 'donor':
                $exists = class_exists(\App\Models\Donor::class)
                    ? \App\Models\Donor::where('id', $userId)->exists()
                    : false;
                break;
            case 'admin':
                $exists = class_exists(\App\Models\Admin::class)
                    ? \App\Models\Admin::where('id', $userId)->exists()
                    : false;
                break;
            default:
                // For unknown types, skip strict existence checks to avoid blocking flows
                $exists = true;
                break;
        }

        if (!$exists) {
            $userTypeLabel = ucfirst($userType);
            \Illuminate\Support\Facades\Log::error("Attempted to generate OTP for non-existent {$userType} ID: " . $userId);
            // Do not block the main flow; just skip OTP generation
            return null;
        }

        // Delete any existing OTPs for this user
        self::where('user_id', $userId)->where('user_type', $userType)->delete();

        // Generate a 6-digit OTP
        $plainOtp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(30); // OTP valid for 30 minutes

        try {
            // Create OTP record with hashed OTP but return the plain OTP for notification
            $verificationOtp = self::create([
                'user_id' => $userId,
                'user_type' => $userType,
                'otp' => Hash::make($plainOtp),
                'expires_at' => $expiresAt,
            ]);
            
            // Store the plain OTP temporarily for notification
            $verificationOtp->plain_otp = $plainOtp;
            
            return $verificationOtp;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to create OTP for {$userType} {$userId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function isValid($otp): bool
    {
        return Hash::check($otp, $this->otp) && $this->expires_at->isFuture();
    }
}

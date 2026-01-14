<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\ResidentResetPasswordNotification;

class Resident extends Authenticatable
{
    use Notifiable, TwoFactorAuthenticatable, CanResetPassword;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birthdate',
        'email',
        'password',
        'phone',
        'house_number',
        'address',
        'subdivision',
        'barangay',
        'city',
        'province',
        'country',
        'postal_code',
        'id_number',
        'id_type',
        'emergency_contact_name',
        'emergency_contact_phone',
        'family_members',
        'family_size',
        'special_needs',
        'evacuation_status',
        'profile_photo_path',
        'email_verified_at',
        'approval_status',
        'rejection_reason',
        'valid_id_front',
        'valid_id_back',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'date',
        'special_needs' => 'array',
        'evacuation_status' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the relief requests for the resident.
     */
    public function reliefRequests(): HasMany
    {
        return $this->hasMany(ReliefRequest::class);
    }

    /**
     * Get the family members for the resident.
     */
    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    /**
     * Get the donations received by the resident.
     */
    public function receivedDonations()
    {
        return $this->hasManyThrough(Distribution::class, ReliefRequest::class, 'resident_id', 'relief_request_id');
    }

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Set the password attribute.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the full address of the resident.
     *
     * @return string
     */
    public function getFullAddressAttribute(): string
    {
        $addressParts = array_filter([
            $this->address,
            $this->barangay,
            $this->city,
            $this->province,
            $this->postal_code
        ]);

        return implode(', ', $addressParts);
    }

    /**
     * Get the evacuation status text.
     *
     * @return string
     */
    public function getEvacuationStatusTextAttribute(): string
    {
        return $this->evacuation_status ? 'Evacuated' : 'At Home';
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResidentResetPasswordNotification($token));
    }

    /**
     * Check if resident is approved.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->approval_status === self::STATUS_APPROVED;
    }

    /**
     * Check if resident is pending approval.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->approval_status === self::STATUS_PENDING;
    }

    /**
     * Check if resident is rejected.
     *
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->approval_status === self::STATUS_REJECTED;
    }

    /**
     * Approve the resident.
     *
     * @return bool
     */
    public function approve(): bool
    {
        return $this->update(['approval_status' => self::STATUS_APPROVED]);
    }

    /**
     * Reject the resident.
     *
     * @return bool
     */
    public function reject(): bool
    {
        return $this->update(['approval_status' => self::STATUS_REJECTED]);
    }
    
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        $name = $this->first_name;
        
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        
        $name .= ' ' . $this->last_name;
        
        if ($this->suffix) {
            $name .= ' ' . $this->suffix;
        }
        
        return $name;
    }

    /**
     * Get the user's age calculated from birthdate.
     *
     * @return int|null
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birthdate) {
            return null;
        }
        return $this->birthdate->age;
    }
}
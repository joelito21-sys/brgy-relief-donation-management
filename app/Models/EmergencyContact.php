<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmergencyContact extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'department',
        'position',
        'address',
        'area_id',
        'is_active',
        'priority',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the area that this emergency contact is associated with.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Scope a query to only include active emergency contacts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include emergency contacts for a specific area.
     */
    public function scopeForArea($query, $areaId)
    {
        return $query->where('area_id', $areaId);
    }

    /**
     * Get the contact's full details.
     */
    public function getContactDetailsAttribute(): string
    {
        $details = [
            $this->name,
            $this->department,
            $this->position,
            $this->phone,
            $this->email,
        ];

        return implode(' • ', array_filter($details));
    }
}

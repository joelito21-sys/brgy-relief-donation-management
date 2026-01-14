<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'location',
        'scheduled_at',
        'is_active',
        'admin_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the admin who created the announcement.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Scope a query to only include active announcements.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include announcements of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include scheduled announcements.
     */
    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduled_at')
                    ->where('scheduled_at', '<=', now());
    }

    /**
     * Get the formatted type display.
     */
    public function getTypeDisplayAttribute(): string
    {
        return match($this->type) {
            'relief_goods' => 'Relief Goods Distribution',
            'feeding_program' => 'Feeding Program',
            'general' => 'General Announcement',
            'emergency' => 'Emergency Alert',
            default => ucfirst($this->type)
        };
    }

    /**
     * Get the type icon.
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'relief_goods' => 'fas fa-box',
            'feeding_program' => 'fas fa-utensils',
            'general' => 'fas fa-bullhorn',
            'emergency' => 'fas fa-exclamation-triangle',
            default => 'fas fa-info-circle'
        };
    }

    /**
     * Get the type color class.
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'relief_goods' => 'blue',
            'feeding_program' => 'green',
            'general' => 'gray',
            'emergency' => 'red',
            default => 'gray'
        };
    }
}

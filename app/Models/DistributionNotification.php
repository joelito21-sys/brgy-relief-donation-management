<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributionNotification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'message',
        'distribution_type',
        'distribution_id',
        'relief_request_id',
        'location',
        'scheduled_date',
        'target_area',
        'additional_info',
        'is_sent',
        'sent_at',
        'sent_by',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'sent_at' => 'datetime',
        'is_sent' => 'boolean',
    ];

    /**
     * Get the distribution associated with this notification.
     */
    public function distribution(): BelongsTo
    {
        return $this->belongsTo(Distribution::class);
    }

    /**
     * Get the relief request associated with this notification.
     */
    public function reliefRequest(): BelongsTo
    {
        return $this->belongsTo(ReliefRequest::class);
    }

    /**
     * Get the admin who sent this notification.
     */
    public function sentBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'sent_by');
    }

    /**
     * Get the confirmations for this notification.
     */
    public function confirmations()
    {
        return $this->hasMany(DistributionConfirmation::class);
    }

    /**
     * Scope a query to only include sent notifications.
     */
    public function scopeSent($query)
    {
        return $query->where('is_sent', true);
    }

    /**
     * Scope a query to only include pending notifications.
     */
    public function scopePending($query)
    {
        return $query->where('is_sent', false);
    }

    /**
     * Scope a query to only include upcoming distributions.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>', now());
    }

    /**
     * Check if the notification is sent.
     */
    public function isSent(): bool
    {
        return $this->is_sent;
    }

    /**
     * Check if the distribution is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->scheduled_date > now();
    }

    /**
     * Get the formatted scheduled date.
     */
    public function getFormattedScheduledDateAttribute(): string
    {
        return $this->scheduled_date->format('F j, Y \a\t g:i A');
    }
}

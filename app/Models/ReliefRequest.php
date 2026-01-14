<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class ReliefRequest extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'relief_requests';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->request_number = 'REQ-' . strtoupper(Str::random(8));
            $model->claim_code = strtoupper(Str::random(8));
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'resident_id',
        'approved_by',
        'request_number',
        'reason',
        'family_members',
        'status',
        'rejection_reason',
        'delivery_method',
        'scheduled_pickup_date',
        'pickup_location',
        'delivery_address',
        'qr_code_path',
        'claim_code',
        // New fields for detailed relief request
        'full_name',
        'contact_number',
        'email_address',
        'id_number',
        'complete_address',
        'city_municipality',
        'province',
        'postal_code',
        'household_size',
        'urgency_level',
        'assistance_types',
        'description',
        'children_count',
        'elderly_count',
        'pwd_count',
        'pregnant_count',
        'additional_message',
        'emergency_contact_name',
        'emergency_contact_phone',
        'submitted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'ready_for_pickup_at' => 'datetime',
        'claimed_at' => 'datetime',
        'delivered_at' => 'datetime',
        'scheduled_pickup_date' => 'datetime',
        'family_members' => 'integer',
        'household_size' => 'integer',
        'children_count' => 'integer',
        'elderly_count' => 'integer',
        'pwd_count' => 'integer',
        'pregnant_count' => 'integer',
        'assistance_types' => 'array',
        'submitted_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status_label', 'delivery_method_label'];

    /**
     * Get the user that owns the relief request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the resident that owns the relief request.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Get the admin who approved the request.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    /**
     * The items that belong to the relief request.
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(ReliefItem::class, 'relief_request_items')
            ->withPivot('quantity', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the distributions associated with the relief request.
     */
    public function distributions()
    {
        return $this->hasMany(Distribution::class, 'relief_request_id');
    }

    /**
     * Get the status label attribute.
     *
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        $statuses = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'ready_for_pickup' => 'Ready for Pickup',
            'claimed' => 'Claimed',
            'delivered' => 'Delivered',
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }

    /**
     * Get the delivery method label attribute.
     *
     * @return string
     */
    public function getDeliveryMethodLabelAttribute(): string
    {
        return $this->delivery_method === 'pickup' ? 'Pickup' : 'Delivery';
    }

    /**
     * Scope a query to only include pending requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Approve the request.
     *
     * @param  int  $adminId
     * @return bool
     */
    public function approve($adminId): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_by' => $adminId,
            'approved_at' => now(),
            'rejected_at' => null,
            'rejection_reason' => null,
        ]);
    }

    /**
     * Reject the request.
     *
     * @param  string  $reason
     * @return bool
     */
    public function reject($reason): bool
    {
        return $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'rejected_at' => now(),
            'approved_at' => null,
            'approved_by' => null,
        ]);
    }

    /**
     * Mark as ready for pickup.
     *
     * @return bool
     */
    public function markAsReadyForPickup(): bool
    {
        return $this->update([
            'status' => 'ready_for_pickup',
            'ready_for_pickup_at' => now(),
        ]);
    }

    /**
     * Mark as claimed.
     *
     * @return bool
     */
    public function markAsClaimed(): bool
    {
        return $this->update([
            'status' => 'claimed',
            'claimed_at' => now(),
        ]);
    }

    /**
     * Mark as delivered.
     *
     * @return bool
     */
    public function markAsDelivered(): bool
    {
        return $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    /**
     * Check if the request is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the request is approved.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the request is rejected.
     *
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if the request is ready for pickup.
     *
     * @return bool
     */
    public function isReadyForPickup(): bool
    {
        return $this->status === 'ready_for_pickup';
    }

    /**
     * Check if the request is claimed.
     *
     * @return bool
     */
    public function isClaimed(): bool
    {
        return $this->status === 'claimed';
    }

    /**
     * Check if the request is delivered.
     *
     * @return bool
     */
    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    /**
     * Get the URL for the document if it exists.
     *
     * @return string|null
     */
    public function getDocumentUrlAttribute(): ?string
    {
        return $this->document_path ? Storage::url($this->document_path) : null;
    }

   
    
    /**
     * Check if the request is declined.
     *
     * @return bool
     */
    public function isDeclined(): bool
    {
        return $this->status === 'declined';
    }

    /**
     * Check if the request is ready for pickup.
     *
     * @return bool
     */
    public function isForPickup(): bool
    {
        return $this->status === 'for_pickup';
    }

    /**
     * Check if the request has been delivered.
     *
     * @return bool
     */
}
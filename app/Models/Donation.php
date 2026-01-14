<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Donation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'donor_id',
        'type',
        'status',
        'message',
        'donor_name',
        'donor_email',
        'donor_phone',
        'donor_address',
        'delivery_method',
        'pickup_date',
        'pickup_time',
        'pickup_address',
        'approved_by',
        'approved_at',
        
        // Cash donation fields
        'amount',
        'payment_method',
        'gcash_amount',
        'paymaya_amount',
        'bank_amount',
        'reference_number',
        'receipt_path',
        'donation_frequency',
        
        // Food donation fields
        'food_type',
        'food_name',
        'quantity',
        'unit',
        'expiry_date',
        'food_description',
        
        // Clothing donation fields
        'clothing_types',
        'other_clothing_type',
        'gender',
        'size',
        'condition',
        'photo_paths',
        
        // Medicine donation fields
        'medicine_type',
        'medicine_name',
        'dosage',
        'form',
        'other_form',
        'prescription_path',
        'payment_details',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gcash_amount' => 'decimal:2',
        'paymaya_amount' => 'decimal:2',
        'bank_amount' => 'decimal:2',
        'pickup_date' => 'date',
        'expiry_date' => 'date',
        'approved_at' => 'datetime',
        'clothing_types' => 'array',
        'photo_paths' => 'array',
        'submitted_at' => 'datetime',
        'payment_details' => 'array',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_RECEIVED = 'received';
    const STATUS_IN_DISTRIBUTION = 'in_distribution';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Type constants
    const TYPE_CASH = 'cash';
    const TYPE_FOOD = 'food';
    const TYPE_CLOTHING = 'clothing';
    const TYPE_MEDICINE = 'medicine';

    // Payment method constants
    const PAYMENT_GCASH = 'gcash';
    const PAYMENT_PAYMAYA = 'paymaya';
    const PAYMENT_BANK = 'bank';
    const PAYMENT_WALKIN = 'walkin';

    /**
     * Get the donor that made the donation.
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    /**
     * Get the admin who approved the donation.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    /**
     * Get the formatted amount with currency symbol.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '₱' . number_format($this->amount, 2);
    }

    /**
     * Get the human-readable type label.
     */
    public function getTypeLabelAttribute(): string
    {
        $types = [
            self::TYPE_CASH => 'Cash Donation',
            self::TYPE_FOOD => 'Food Donation',
            self::TYPE_CLOTHING => 'Clothing Donation',
            self::TYPE_MEDICINE => 'Medicine Donation',
        ];

        return $types[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Get the human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        $statuses = [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_RECEIVED => 'Received',
            self::STATUS_IN_DISTRIBUTION => 'In Distribution',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get the URL for the receipt if it exists.
     */
    public function getReceiptUrlAttribute(): ?string
    {
        return $this->receipt_path ? Storage::url($this->receipt_path) : null;
    }

    /**
     * Get the URL for the prescription if it exists.
     */
    public function getPrescriptionUrlAttribute(): ?string
    {
        return $this->prescription_path ? Storage::url($this->prescription_path) : null;
    }

    /**
     * Get the URLs for the clothing photos if they exist.
     */
    public function getPhotoUrlsAttribute(): array
    {
        if (empty($this->photo_paths)) {
            return [];
        }

        return array_map(function ($path) {
            return Storage::url($path);
        }, $this->photo_paths);
    }

    /**
     * Scope a query to only include pending donations.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include received donations.
     */
    public function scopeReceived($query)
    {
        return $query->where('status', self::STATUS_RECEIVED);
    }

    /**
     * Check if the donation is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the donation is a cash donation.
     */
    public function isCashDonation(): bool
    {
        return $this->type === self::TYPE_CASH;
    }

    /**
     * Check if the donation is a food donation.
     */
    public function isFoodDonation(): bool
    {
        return $this->type === self::TYPE_FOOD;
    }

    /**
     * Check if the donation is a clothing donation.
     */
    public function isClothingDonation(): bool
    {
        return $this->type === self::TYPE_CLOTHING;
    }

    /**
     * Check if the donation is a medicine donation.
     */
    public function isMedicineDonation(): bool
    {
        return $this->type === self::TYPE_MEDICINE;
    }

    /**
     * Check if payment method is GCash.
     */
    public function isGcashPayment(): bool
    {
        return $this->payment_method === self::PAYMENT_GCASH;
    }

    /**
     * Check if payment method is PayMaya.
     */
    public function isPaymayaPayment(): bool
    {
        return $this->payment_method === self::PAYMENT_PAYMAYA;
    }

    /**
     * Check if payment method is Bank.
     */
    public function isBankPayment(): bool
    {
        return $this->payment_method === self::PAYMENT_BANK;
    }

    /**
     * Check if payment method is Walk-in.
     */
    public function isWalkinPayment(): bool
    {
        return $this->payment_method === self::PAYMENT_WALKIN;
    }

    /**
     * Get the payment method label.
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        $methods = [
            self::PAYMENT_GCASH => 'GCash',
            self::PAYMENT_PAYMAYA => 'PayMaya',
            self::PAYMENT_BANK => 'Bank Transfer',
            self::PAYMENT_WALKIN => 'Walk-in Appointment',
        ];

        return $methods[$this->payment_method] ?? ucfirst($this->payment_method);
    }

    /**
     * Scope a query to only include GCash donations.
     */
    public function scopeGcash($query)
    {
        return $query->where('payment_method', self::PAYMENT_GCASH);
    }

    /**
     * Scope a query to only include PayMaya donations.
     */
    public function scopePaymaya($query)
    {
        return $query->where('payment_method', self::PAYMENT_PAYMAYA);
    }

    /**
     * Scope a query to only include Bank donations.
     */
    public function scopeBank($query)
    {
        return $query->where('payment_method', self::PAYMENT_BANK);
    }
}

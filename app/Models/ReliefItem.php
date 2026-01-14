<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ReliefItem extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'quantity_available',
        'quantity_reserved',
        'unit',
        'weight_kg',
        'expiry_date',
        'barcode',
        'image_path',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'quantity_available' => 'integer',
        'quantity_reserved' => 'integer',
        'weight_kg' => 'decimal:2',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * The relief requests that belong to the relief item.
     */
    public function reliefRequests(): BelongsToMany
    {
        return $this->belongsToMany(ReliefRequest::class, 'relief_request_items')
            ->withPivot('quantity', 'notes')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the total quantity (available + reserved).
     *
     * @return int
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->quantity_available + $this->quantity_reserved;
    }

    /**
     * Check if the item is in stock.
     *
     * @return bool
     */
    public function isInStock(): bool
    {
        return $this->quantity_available > 0;
    }

    /**
     * Check if the item is low in stock.
     *
     * @param  int  $threshold
     * @return bool
     */
    public function isLowStock(int $threshold = 10): bool
    {
        return $this->quantity_available <= $threshold;
    }

    /**
     * Get the type label attribute.
     *
     * @return string
     */
    public function getTypeLabelAttribute(): string
    {
        $types = [
            'food' => 'Food',
            'clothing' => 'Clothing',
            'medicine' => 'Medicine',
            'hygiene' => 'Hygiene',
            'other' => 'Other',
        ];

        return $types[$this->type] ?? 'Other';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'unit_price',
        'unit_measure',
        'category_id',
        'status',
        'reorder_level',
        'location',
        'barcode',
        'image',
        'is_active'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'reorder_level' => 'integer',
        'is_active' => 'boolean'
    ];

    protected $appends = [
        'total_value'
    ];

    /**
     * Get the category that owns the inventory item.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(InventoryCategory::class, 'category_id');
    }

    /**
     * Get the transactions for the inventory item.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'item_id');
    }

    /**
     * Get the last transaction for the inventory item.
     */
    public function lastTransaction()
    {
        return $this->hasOne(InventoryTransaction::class, 'item_id')->latest();
    }

    /**
     * Calculate the total value of the inventory item.
     */
    public function getTotalValueAttribute(): float
    {
        return $this->quantity * $this->unit_price;
    }

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include low stock items.
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'reorder_level')
                    ->where('quantity', '>', 0);
    }

    /**
     * Scope a query to only include out of stock items.
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }
}

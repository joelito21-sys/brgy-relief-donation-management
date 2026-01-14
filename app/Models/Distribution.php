<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distribution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'relief_request_id',
        'distributed_by',
        'distribution_date',
        'status',
        'notes',
        'area_id',
        'scheduled_for',
        'completed_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'distribution_date' => 'datetime',
        'scheduled_for' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'distribution_date',
        'scheduled_for',
        'completed_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the relief request that the distribution belongs to.
     */
    public function reliefRequest(): BelongsTo
    {
        return $this->belongsTo(ReliefRequest::class, 'relief_request_id');
    }

    /**
     * Get the user who distributed the relief.
     */
    public function distributedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'distributed_by');
    }

    /**
     * Get the area where the distribution is taking place.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get the items being distributed.
     */
    public function items()
    {
        return $this->hasMany(DistributionItem::class);
    }
}

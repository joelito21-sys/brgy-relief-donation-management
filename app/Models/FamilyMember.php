<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'resident_id',
        'full_name',
        'relationship',
        'age',
    ];

    /**
     * Get the resident that this family member belongs to.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}

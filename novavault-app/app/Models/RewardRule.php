<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RewardRule extends Model
{
    protected $fillable = [
        'vendor_id',
        'earn_rate',
        'min_purchase',
        'multiplier',
        'active',
        'valid_from',
        'valid_until',
    ];

    protected function casts(): array
    {
        return [
            'earn_rate' => 'decimal:4',
            'min_purchase' => 'decimal:2',
            'multiplier' => 'decimal:2',
            'active' => 'boolean',
            'valid_from' => 'datetime',
            'valid_until' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}

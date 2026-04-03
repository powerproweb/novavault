<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoyaltyTier extends Model
{
    protected $fillable = [
        'vendor_id', 'name', 'spend_threshold', 'earn_multiplier', 'perks_json', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'spend_threshold' => 'decimal:2',
            'earn_multiplier' => 'decimal:2',
            'perks_json' => 'array',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}

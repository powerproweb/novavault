<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsSnapshot extends Model
{
    protected $fillable = [
        'vendor_id', 'date', 'transactions_count', 'revenue',
        'tokens_issued', 'tokens_redeemed', 'active_patrons',
        'new_patrons', 'repeat_patrons',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'revenue' => 'decimal:2',
            'tokens_issued' => 'decimal:8',
            'tokens_redeemed' => 'decimal:8',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}

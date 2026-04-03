<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Redemption extends Model
{
    protected $fillable = [
        'wallet_id',
        'patron_id',
        'vendor_id',
        'amount',
        'reward_type',
        'reward_detail_json',
        'status',
        'confirmation_code',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:8',
            'reward_detail_json' => 'array',
        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function patron(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patron_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}

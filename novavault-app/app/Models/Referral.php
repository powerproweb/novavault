<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    protected $fillable = [
        'referrer_id', 'referred_id', 'vendor_id', 'status',
        'bonus_amount', 'referral_code', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'bonus_amount' => 'decimal:8',
            'completed_at' => 'datetime',
        ];
    }

    public function referrer(): BelongsTo { return $this->belongsTo(User::class, 'referrer_id'); }
    public function referred(): BelongsTo { return $this->belongsTo(User::class, 'referred_id'); }
    public function vendor(): BelongsTo { return $this->belongsTo(Vendor::class); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'balance',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:8',
        ];
    }

    // ----- Relationships -----

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function ledgerEntries(): HasMany
    {
        return $this->hasMany(TokenLedger::class);
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(Redemption::class);
    }
}

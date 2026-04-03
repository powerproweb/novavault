<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TokenLedger extends Model
{
    public $timestamps = false;

    protected $table = 'token_ledger';

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'reference_type',
        'reference_id',
        'memo',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:8',
            'created_at' => 'datetime',
        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}

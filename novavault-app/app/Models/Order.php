<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'patron_id',
        'status',
        'total',
        'payment_intent_id',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    // ----- Relationships -----

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function patron(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patron_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentEvents(): HasMany
    {
        return $this->hasMany(PaymentEvent::class);
    }
}

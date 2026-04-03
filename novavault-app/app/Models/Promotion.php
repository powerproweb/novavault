<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    protected $fillable = [
        'vendor_id',
        'name',
        'type',
        'config_json',
        'active',
        'start_at',
        'end_at',
    ];

    protected function casts(): array
    {
        return [
            'config_json' => 'array',
            'active' => 'boolean',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}

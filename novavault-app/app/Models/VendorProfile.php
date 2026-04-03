<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorProfile extends Model
{
    protected $fillable = [
        'vendor_id',
        'address',
        'website',
        'social_links_json',
        'about_text',
    ];

    protected function casts(): array
    {
        return [
            'social_links_json' => 'array',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}

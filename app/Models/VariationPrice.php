<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariationPrice extends Model
{
    protected $fillable = [
        'productVariationId',
        'startDate',
        'endDate',
        'price',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductVariations::class);
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }
}

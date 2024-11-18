<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariations extends Model
{
    protected $fillable = [
        'productId',
        'variationId',
        'name',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productId');
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class, 'variationId');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(VariationPrice::class, 'productVariationId');
    }

    public function ordered(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'productVariationId');
    }
}

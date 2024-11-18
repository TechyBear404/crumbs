<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variation extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(ProductVariations::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'isAllergen',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products_ingredients', 'ingrId', 'prodId');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'catid',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'catid');
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'products_ingredients', 'prodId', 'ingrId');
    }
}

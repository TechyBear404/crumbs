<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
    protected $table = 'products_ingredients';
    protected $fillable = [
        'prodId',
        'ingrId',
    ];
}

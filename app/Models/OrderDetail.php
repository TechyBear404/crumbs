<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'orderId',
        'productVariationId',
        'qty',
        'comment',
        'unitPrice'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId');
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariations::class, 'productVariationId');
    }
}

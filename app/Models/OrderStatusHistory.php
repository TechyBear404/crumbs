<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderStatusHistory extends Pivot
{
    protected $fillable = [
        'orderId',
        'orderStatusId',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'orderId');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'orderStatusId');
    }
}

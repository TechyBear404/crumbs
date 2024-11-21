<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'userId',
        'orderDate'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'orderId');
    }

    public function status()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_status_history', 'orderId', 'orderStatusId');
    }
}

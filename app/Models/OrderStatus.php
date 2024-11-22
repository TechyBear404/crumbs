<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    protected $fillable = ['name', 'description'];

    protected $table = 'order_status'; // Add this line to specify the table name

    public function orders(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class, 'orderStatusId');
    }

    public function historicalOrders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_status_history', 'orderStatusId', 'orderId');
    }
}

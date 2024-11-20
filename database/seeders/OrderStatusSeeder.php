<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderStatuses = [
            ['name' => 'Pending'],
            ['name' => 'Delivered'],
            ['name' => 'Payed'],
            ['name' => 'Cancelled'],
        ];

        foreach ($orderStatuses as $orderStatus) {
            OrderStatus::create($orderStatus);
        }
    }
}

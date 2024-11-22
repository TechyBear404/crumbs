<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderStatus = [
            ['name' => 'Pending'],
            ['name' => 'Delivered'],
            ['name' => 'Payed'],
            ['name' => 'Cancelled'],
        ];

        foreach ($orderStatus as $status) {
            OrderStatus::create(['name' => $status['name']]);
        }
    }
}

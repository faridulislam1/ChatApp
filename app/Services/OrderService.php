<?php

namespace App\Services;

class OrderService
{
    public function allOrders()
    {
        return [
            ['id' => 1, 'item' => 'Laptop'],
            ['id' => 2, 'item' => 'Phone'],
            ['id' => 3, 'item' => 'Laptop'],
            ['id' => 2, 'item' => 'Phone'],
        ];
    }


    
}

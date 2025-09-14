<?php

namespace Database\Factories;
use App\Models\Order;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'CustomerName' => $this->faker->company,
            'OrderID' => $this->faker->numberBetween(10248, 20248),
        ];
    }

    
}

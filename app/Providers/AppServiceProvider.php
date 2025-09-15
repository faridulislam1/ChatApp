<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OrderService;
use App\Contracts\PaymentGateway;
use App\Services\StripePaymentGateway;
class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderService::class, function ($app) {
            return new OrderService();

         $this->app->bind(PaymentGateway::class, StripePaymentGateway::class);

        });

      
    }

    public function boot()
    {
        
    }
}

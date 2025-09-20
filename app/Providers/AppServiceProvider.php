<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OrderService;
use App\Contracts\PaymentGateway;
use App\Facades\Math;
use App\Services\StripePaymentGateway;
use App\Services\MathService;


class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderService::class, function ($app) {
            return new OrderService();
         $this->app->bind(PaymentGateway::class, StripePaymentGateway::class);
        });    
        $this->app->singleton('math', function () {
        return new \App\Services\MathService();
        return new Math();
    });

     $this->app->singleton('notification', function () {
        return new \App\Services\NotificationService();
    });
    }

    public function boot()
    {
        
    }


}

<?php

namespace App\Services;

use App\Contracts\PaymentGateway;

class StripePaymentGateway implements PaymentGateway
{
    public function pay($amount)
    {
        return "Paid {$amount} using Stripe";
    }
}

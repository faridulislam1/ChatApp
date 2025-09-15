<?php

namespace App\Contracts;

interface PaymentGateway
{
    public function pay($amount);
}

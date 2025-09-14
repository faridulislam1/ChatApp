<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   protected $fillable = [
        'transaction_id',
        'status',
        'amount',
        'currency',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'gateway_response'
    ];

    protected $casts = [
        'gateway_response' => 'array',
    ];
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function showForm()
    {
        return view('payment'); 
    }

    public function pay(Request $request)
    {
        $post_data = [
            'store_id' => config('sslcommerz.store_id'),
            'store_passwd' => config('sslcommerz.store_password'),
            'total_amount' => $request->amount ?? 100,
            'currency' => 'BDT',
            'tran_id' => uniqid(),
            'success_url' => route('success'),
            'fail_url' => route('fail'),
            'cancel_url' => route('cancel'),
            'cus_name' => $request->name ?? 'Test User',
            'cus_email' => $request->email ?? 'test@example.com',
            'cus_add1' => 'Dhaka',
            'cus_phone' => $request->phone ?? '01711111111',
            'product_name' => 'Demo Product',
            'product_category' => 'General',
            'product_profile' => 'general',
        ];

       $url = config('sslcommerz.sandbox') 
    ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php'
    : 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';


      $response = Http::asForm()->post($url, $post_data)->json();
      dd($response);


        if(isset($response['GatewayPageURL'])) {
            return redirect()->away($response['GatewayPageURL']); 
        } else {
            return response()->json($response); 
        }
    }

    public function success(Request $request)
    {
        return "Payment Successful! Transaction ID: " . $request->tran_id;
    }

    public function fail(Request $request)
    {
        return "Payment Failed!";
    }

    public function cancel(Request $request)
    {
        return "Payment Cancelled!";
    }
}

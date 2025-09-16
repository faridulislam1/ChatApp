<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use App\Models\Images;
use App\Facades\Math;
use App\Services\PaymentService;

class ChatController extends Controller
    {

    public function ask(Request $request)
    {
        $question = $request->input('question');
        $response = $this->handleQuestion($question);
        return response()->json(['answer' => $response]);
    }
   private function handleQuestion($question)
    {
    if (str_contains(strtolower($question), 'total order')) {
        $count = DB::table('orders')->count();
        return "Total orders: $count";
    }

    if (str_contains(strtolower($question), 'total customer')) {
        $count = DB::table('customers')->count();
        return "Total customers: $count";
    }
    
    if (str_contains(strtolower($question), 'same customer')) {
        $duplicates = DB::table('customers')
            ->select('name', DB::raw('count(*) as  '))
            ->groupBy('name')
            ->havingRaw('count(*) > 1')
            ->get();
        return $duplicates->isEmpty() ? "No duplicate customers" : $duplicates;
    }

    if (str_contains(strtolower($question), 'aircode')) {
        $count = DB::table('aircodes')->count();
        return "Total Aircode records: $count";
    }

    if (str_contains(strtolower($question), 'customer name same')) {
        $duplicates = DB::table('orders')
            ->select('CustomerName', DB::raw('count(*) as count'))
            ->groupBy('CustomerName')
            ->havingRaw('count(*) > 1')
            ->get();
        return $duplicates->isEmpty() ? "No duplicate customer names in orders" : $duplicates;
    }

    if (str_contains(strtolower($question), 'customer name 3 digit')) {
        $threeDigitCount = DB::table('orders')
            ->whereRaw('LENGTH(CustomerName) = 3 AND CustomerName REGEXP "^[0-9]+$"')
            ->count();
        return "Customer names with exactly 3 digits: $threeDigitCount";
    }

    return "Sorry, I don't understand the question yet.";
   }


  public function makePayment()
    {
        $payment = new PaymentService();
        return $payment->process();
    }


    public function calculate()
    {
        $sum = Math::add(10, 5);
        $product = Math::multiply(10, 5);

        return "Sum: $sum, Product: $product";
    }

    }

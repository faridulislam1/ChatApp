<?php

namespace App\Http\Controllers;

use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        // Dependency injection via Service Container
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->allOrders();
        return response()->json($orders);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class Cus_OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())
                       ->latest()
                       ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('id', $id)
                      ->where('customer_id', Auth::id())
                      ->firstOrFail();

        return view('customer.orders_show', compact('order'));
    }
}


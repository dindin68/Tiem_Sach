<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start_date') ?? now()->startOfMonth()->toDateString();
        $end = $request->input('end_date') ?? now()->endOfMonth()->toDateString();

        $orders = Order::whereBetween('date_order', [$start, $end])
                        ->where('status', 'Hoàn thành')
                        ->get();

        $totalRevenue = $orders->sum('total_cost');

        return view('admin.revenue.index', compact('orders', 'totalRevenue', 'start', 'end'));
    }
}


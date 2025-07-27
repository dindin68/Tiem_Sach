<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\Promotion;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $revenueToday = Order::whereDate('date_order', today())->sum('total_cost');
        $pendingOrders = Order::where('status', '!=', 'Hoàn thành')->count();
        $recentOrders = Order::with('customer')->latest('date_order')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalOrders',
            'revenueToday',
            'pendingOrders',
            'recentOrders'
        ));
    }
    
}
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
        return view('admin.dashboard');
    }
    public function books()
    {
        $books = Book::with('category')->paginate(12);
        return view('admin.books.index', compact('books'));
    }

    public function orders()
    {
        $orders = Order::with('customer', 'items.book')->paginate(12);
        return view('admin.orders.index', compact('orders'));
    }

    public function promotions()
    {
        $books = Promotion::with('category')->paginate(12);
        return view('admin.promotion.index', compact('promotions'));
    }
    public function updateOrder(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,completed,cancelled']);
        $order->update(['status' => $request->status]);
        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái thành công.');
    }
}
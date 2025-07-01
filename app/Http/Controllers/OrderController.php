<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }
        return view('orders.create', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $totalCost = 0;
        foreach ($cart as $item) {
            $totalCost += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'id' => Str::uuid()->toString(),
            'customer_id' => Auth::guard('web')->id(),
            'total_cost' => $totalCost,
            'status' => 'pending',
        ]);

        foreach ($cart as $bookId => $item) {
            OrderItem::create([
                'id' => Str::uuid()->toString(),
                'order_id' => $order->id,
                'book_id' => $bookId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $book = Book::find($bookId);
            $book->update([
                'stock' => $book->stock - $item['quantity'],
                'sold' => $book->sold + $item['quantity'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('dashboard')->with('success', 'Đặt hàng thành công.');
    }
}
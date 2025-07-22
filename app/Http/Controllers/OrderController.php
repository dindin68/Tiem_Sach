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
    $buyNow = session()->get('buy_now');
    $cart = session()->get('cart');

    if ($buyNow) {
        // ==== MUA NGAY ====
        $book = Book::findOrFail($buyNow['book_id']);
        $quantity = $buyNow['quantity'];
        $price = $buyNow['price'];
        $total = $price * $quantity;

        $order = Order::create([
            'id' => Str::uuid(),
            'customer_id' => Auth::id(),
            'total_cost' => $total,
            'status' => 'pending',
        ]);

        OrderItem::create([
            'id' => Str::uuid(),
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => $quantity,
            'price' => $price,
        ]);

        // Cập nhật sách
        $book->update([
            'stock' => $book->stock - $quantity,
            'sold' => $book->sold + $quantity,
        ]);

        session()->forget('buy_now');

    } elseif ($cart) {
        // ==== GIỎ HÀNG ====
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'id' => Str::uuid(),
            'customer_id' => Auth::id(),
            'total_cost' => $total,
            'status' => 'pending',
        ]);

        foreach ($cart as $bookId => $item) {
            OrderItem::create([
                'id' => Str::uuid(),
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

    } else {
        return redirect()->back()->with('error', 'Không có sản phẩm để thanh toán.');
    }

    return redirect()->route('dashboard')->with('success', 'Thanh toán thành công!');
}
}
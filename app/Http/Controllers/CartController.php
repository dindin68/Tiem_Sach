<?php

namespace App\Http\Controllers;

use App\Models\Book;

use Illuminate\Http\Request;


class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);
        
        // Lấy sách
        $book = Book::findOrFail($id);

        // Logic thêm vào giỏ hàng - ví dụ session
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'title' => $book->title,
                'price' => $book->discounted_price ?? $book->price,
                'quantity' => $quantity,
            ];
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
    }

}

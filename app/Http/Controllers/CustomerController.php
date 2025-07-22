<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    protected function getCartItemCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('customer_id', Auth::id())->first();
            return $cart ? $cart->items->sum('quantity') : 0;
        }
        return 0;
    }

    public function index()
    {
        $newBooks = Book::with(['promotions', 'images', 'authors'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get()
            ->map(function ($book) {
                $book->discounted_price = $this->getDiscountedPrice($book);
                return $book;
            });

        $discountedBooks = Book::with([
            'promotions' => function ($query) {
                $query->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
            },
            'images',
            'authors'
        ])
            ->whereHas('promotions', function ($query) {
                $query->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
            })
            ->orderByDesc('created_at')
            ->take(10)
            ->get()
            ->map(function ($book) {
                $book->discounted_price = $this->getDiscountedPrice($book);
                return $book;
            });

        $cartItemCount = $this->getCartItemCount();

        return view('customer.index', compact('cartItemCount', 'newBooks', 'discountedBooks'));
    }

    public function books()
    {
        $books = Book::with('category', 'images')->paginate(12);
        $cartItemCount = $this->getCartItemCount();
        return view('customer.books.index', compact('books', 'cartItemCount'));
    }

    protected function getDiscountedPrice($book)
    {
        $promotion = $book->promotions
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if ($promotion) {
            return round($book->price * (1 - $promotion->discount_percentage / 100));
        }

        return null; // không có khuyến mãi
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Cus_BookshelfController extends Controller
{
    protected function getCartItemCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('customer_id', Auth::id())->first();
            return $cart ? $cart->items->sum('quantity') : 0;
        }
        return 0;
    }

    public function index(Request $request)
{
    $query = Book::with(['images', 'authors', 'category']);
    $categoryName = null;

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
        $category = Category::find($request->category);
        $categoryName = $category ? $category->name : null;
    }

    $books = $query->orderBy('title')->paginate(12);
    $cartItemCount = $this->getCartItemCount();

    return view('customer.bookshelf', compact('books', 'cartItemCount', 'categoryName'));
}

public function filterByCategory($id)
{
    $query = Book::with(['images', 'authors', 'category'])->where('category_id', $id);
    $books = $query->orderBy('title')->paginate(12);
    $cartItemCount = $this->getCartItemCount();
    $category = Category::find($id);
    $categoryName = $category ? $category->name : null;

    return view('customer.bookshelf', compact('books', 'cartItemCount', 'categoryName'));
}


}


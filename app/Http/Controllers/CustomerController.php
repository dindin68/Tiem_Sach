<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CustomerController extends Controller
{   
    
    public function index()
    {
        $books = Book::with('images')->take(10)->get();
        return view('customer.index', compact('books'));
    }

    public function books()
    {
        $books = Book::with('category', 'images')->paginate(12);
        return view('customer.books.index', compact('books'));
    }
}
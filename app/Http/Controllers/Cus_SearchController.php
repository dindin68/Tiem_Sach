<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class Cus_SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $books = Book::with('authors', 'category')
            ->where('title', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%")
            ->get();

        $authors = Author::with('books')
            ->where('name', 'like', "%{$query}%")
            ->get();

        return view('customer.result_search', compact('query', 'books', 'authors'));
    }
}


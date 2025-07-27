<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class Cus_AuthorController extends Controller
{
   public function index()
    {
        $authors = Author::withCount('books')->paginate(16);
        return view('customer.authors', compact('authors'));
    }

    public function show($id)
    {
        $author = Author::with('books.category')->findOrFail($id);

        return view('customer.authors_show', compact('author'));
    }

}

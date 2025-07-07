<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Promotion;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'images'])->paginate(12);
        $promotions = Promotion::all();
        return view('admin.books.index', compact('books','promotions'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|unique:books,id|max:255',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = Book::create([
            'id' => $request->id,
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'price' => $request->price,
            'stock' => $request->stock,
            'imported' => $request->stock,
            'sold' => 0,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('books', 'public');

                Image::create([
                    'id' => Str::uuid()->toString(),
                    'book_id' => $book->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.books.index')->with('success', 'Thêm sách thành công.');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        $book->load('images');
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book->update($request->only(['title', 'author', 'publisher', 'price', 'stock', 'category_id']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('books', 'public');

                Image::create([
                    'id' => Str::uuid()->toString(),
                    'book_id' => $book->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.books.index')->with('success', 'Cập nhật sách thành công.');
    }


    public function destroy(Book $book)
    {
        foreach ($book->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Xóa sách thành công.');
    }
}

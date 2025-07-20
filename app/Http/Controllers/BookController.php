<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Promotion;
use App\Models\Image;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'images'])->paginate(20);
        $promotions = Promotion::all();
        return view('admin.books.index', compact('books', 'promotions'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        return view('admin.books.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'id' => 'required|string|unique:books,id|max:255',
            'title' => 'required|string|max:255',
            'author_ids' => 'required|array',
            'author_ids.*' => 'exists:authors,id',
            'publisher' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = Book::create([
            'id' => $request->id,
            'title' => $request->title,
            'publisher' => $request->publisher,
            'price' => $request->price,
            'stock' => 0,
            'imported' => 0,
            'sold' => 0,
            'category_id' => $request->category_id,
        ]);

        $book->authors()->attach($request->author_ids);

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
        $authors = Author::all();
        $book->load('images');
        $bookAuthorIds = $book->authors->pluck('id')->toArray();
        return view('admin.books.edit', compact('book', 'categories', 'authors', 'bookAuthorIds'));
    }


    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_ids' => 'required|array',
            'author_ids.*' => 'exists:authors,id',
            'publisher' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Cập nhật thông tin sách
        $book->update([
            'title' => $request->title,
            'publisher' => $request->publisher,
            'price' => $request->price,
            'stock' => 0,
            'category_id' => $request->category_id,
        ]);

        // Cập nhật tác giả (bảng trung gian author_book)
        $book->authors()->sync($request->author_ids);

        // Thêm hình ảnh nếu có upload mới
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

    public function filterByCategory($id)
    {
        // Lấy thể loại
        $category = Category::findOrFail($id);

        // Lấy sách thuộc thể loại đó, có phân trang
        $books = Book::where('category_id', $id)->paginate(12);

        // Trả về view, kèm dữ liệu
        return view('books.index', [
            'books' => $books,
            'selectedCategory' => $category
        ]);
    }

    

}

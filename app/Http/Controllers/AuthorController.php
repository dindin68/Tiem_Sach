<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Author::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%");
            });
        }

        $authors = $query->orderBy('name')->paginate(20);

        return view('admin.authors.index', compact('authors'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:authors,name',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'infor' => 'nullable|string|max:5000',
        ], [
            'name.unique' => 'Tên tác giả đã tồn tại.',
        ]);
        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('authors', 'public');
        }

        do {
            $id = Str::random(8);
        } while (Author::where('id', $id)->exists());

        Author::create([
            'id' => $id, // dùng đúng biến $id đã tạo ở trên
            'name' => $request->name,
            'infor' => $request->infor ?? '',
            'photo' => $photo,
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'Đã thêm tác giả thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'infor' => 'nullable|string|max:5000',
        ], [
            'name.unique' => 'Tên tác giả đã tồn tại.',
        ]);

        if ($request->hasFile('photo')) {
            if ($author->photo && Storage::disk('public')->exists($author->photo)) {
                Storage::disk('public')->delete($author->photo);
            }

            $author->photo = $request->file('photo')->store('authors', 'public');
        }

        $author->name = $request->name;
        $author->infor = $request->infor ?? '';
        $author->save();

        return redirect()->route('admin.authors.index')->with('success', 'Đã cập nhật tác giả!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        if ($author->photo && Storage::disk('public')->exists($author->photo)) {
            Storage::disk('public')->delete($author->photo);
        }

        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Đã xóa tác giả!');
    }
}

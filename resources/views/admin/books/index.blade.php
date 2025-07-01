@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">Quản lý sách</h1>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('admin.books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">Thêm sách mới</a>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Tiêu đề</th>
                <th class="border p-2">Tác giả</th>
                <th class="border p-2">Giá</th>
                <th class="border p-2">Tồn kho</th>
                <th class="border p-2">Danh mục</th>
                <th class="border p-2">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
            <tr>
                <td class="border p-2">{{ $book->title }}</td>
                <td class="border p-2">{{ $book->author }}</td>
                <td class="border p-2">{{ number_format($book->price, 2) }} USD</td>
                <td class="border p-2">{{ $book->stock }}</td>
                <td class="border p-2">{{ $book->category->name }}</td>
                <td class="border p-2">
                    <a href="{{ route('admin.books.edit', $book) }}" class="text-blue-500 hover:underline">Sửa</a>
                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Xóa sách này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $books->links() }}
</div>
@endsection
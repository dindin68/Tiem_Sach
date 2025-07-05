@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4">
        <div class="flex justify-between p-6 mt-2 bg-brown-100 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <h2 class="text-2xl font-bold text-brown-800">Danh Sách Sách</h2>

            <div class="flex flex-row mt-4">
                    <!-- Tìm kiếm -->
                <div class="relative w-72">
                    <input
                        type="text"
                        placeholder="Tìm kiếm sách..."
                        class="w-full h-10 pr-10 border border-gray-300 rounded-lg shadow-sm
                            focus:outline-none focus:ring-2 focus:ring-blue-500" />

                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                        </svg>
                    </div>

                </div>
                    <a href="{{ route('admin.books.create') }}" class=" inline-block bg-green-800 mx-2 text-white px-4 py-2 rounded">Thêm Sách Mới</a>
            </div>                   
        </div>
    <table class="w-full mt-4 border-collapse text-center">
        <thead>
            <tr class="bg-green-100 text-brown-800">
                <th class="border p-2">Mã Sách</th>
                <th class="border p-2">Hình ảnh</th>
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
                <td class="border p-2">{{ $book->id }}</td>
                <td class="border p-2">
                    @if ($book->images->first())
                        <img src="{{ Storage::url($book->images->first()->path) }}" alt="{{ $book->title }}" class="w-16 h-16 object-cover">
                    @else
                        <div class="w-16 h-16 bg-gray-200 flex items-center justify-center">No Image</div>
                    @endif
                </td>
                <td class="border p-2">{{ $book->title }}</td>
                <td class="border p-2">{{ $book->author }}</td>
                <td class="border p-2">{{ number_format($book->price) }} VND</td>
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
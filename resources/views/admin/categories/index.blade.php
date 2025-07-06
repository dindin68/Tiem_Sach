@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between p-6 mt-2 bg-orange-50 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <h2 class="text-2xl font-bold text-brown-800">Danh Sách Thể Loại</h2>

            <div class="flex flex-row mt-4">
                    <!-- Tìm kiếm -->
                <div class="relative w-72">
                    <input
                        type="text"
                        placeholder="Tìm kiếm thể loại..."
                        class="w-full h-10 pr-10 border border-gray-300 rounded-lg shadow-sm
                            focus:outline-none focus:ring-2 focus:ring-blue-500" />

                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                        </svg>
                    </div>

                </div>
                    <a href="{{ route('admin.categories.create') }}" class=" inline-block bg-green-800 text-white mx-2 px-4 py-2 rounded">Thêm Sách Mới</a>
            </div>                   
    </div>
    <table class="min-w-full mt-4 border rounded text-center ">
        <thead>
            <tr class="bg-green-100 text-brown-800">
                <th class="px-4 py-2 border">Mã thể loại</th>
                <th class="px-4 py-2 border">Tên danh mục</th>
                <th class="px-4 py-2 border">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td class="border px-4 py-2">{{ $category->id }}</td>
                <td class="border px-4 py-2">{{ $category->name }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600">Sửa</a> |
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Bạn có chắc chắn?')" class="text-red-600">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

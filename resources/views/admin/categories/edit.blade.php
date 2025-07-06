@extends('admin.layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Sửa danh mục</h1>
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="flex flex-row items-end space-x-4">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Tên danh mục</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="border rounded px-4 py-2 w-full" required>
                </div>
                <div class="mb-4">
                    <button class="bg-green-800 text-white px-4 py-2 rounded">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>

@endsection

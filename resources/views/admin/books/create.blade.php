@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4 max-w-md">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">Thêm sách mới</h1>
    <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
        @csrf
         <div class="mb-4">
            <label for="id" class="block text-gray-700">Mã Sách</label>
            <input type="text" name="id" id="id" value="{{ old('id') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="images" class="block text-gray-700">Hình ảnh</label>
            <input type="file" name="images[]" id="images" multiple
                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('images')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
            @error('images.*')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Tiêu đề</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('title')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="author" class="block text-gray-700">Tác giả</label>
            <input type="text" name="author" id="author" value="{{ old('author') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('author')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="publisher" class="block text-gray-700">Nhà xuất bản</label>
            <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('publisher')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="price" class="block text-gray-700">Giá (USD)</label>
            <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('price')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="stock" class="block text-gray-700">Tồn kho</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('stock')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-gray-700">Danh mục</label>
            <select name="category_id" id="category_id" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Thêm sách</button>
    </form>
</div>
@endsection
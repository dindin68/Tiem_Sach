@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto px-4 md:px-6 py-6 max-w-4xl mt-2 bg-white shadow rounded-lg">
    <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">Thêm Sách Mới</h1>

    <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Mã sách -->
            <div>
                <label for="id" class="block text-sm font-medium text-gray-700">Mã Sách</label>
                <input type="text" name="id" id="id" value="{{ old('id') }}"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('id') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Danh mục -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục</label>
                <select name="category_id" id="category_id"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Tiêu đề -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('title') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Nhà xuất bản -->
            <div>
                <label for="publisher" class="block text-sm font-medium text-gray-700">Nhà xuất bản</label>
                <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('publisher') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Giá -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Giá</label>
                <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('price') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Tác giả -->
            <div class="md:col-span-2">
                <label for="author_ids" class="block text-sm font-medium text-gray-700">Chọn tác giả</label>
                <select id="author_ids" name="author_ids[]" multiple
                        class="mt-1 block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" {{ in_array($author->id, old('author_ids', [])) ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
                @error('author_ids.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('author_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Hình ảnh -->
            <div class="md:col-span-2">
                <label for="images" class="block text-sm font-medium text-gray-700">Hình ảnh</label>
                <input type="file" name="images[]" id="images" multiple
                       class="mt-1 block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('images') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                @error('images.*') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Thêm sách
            </button>
        </div>
    </form>
</div>
 <!-- @if ($errors->any())
    <div class="mt-4 bg-red-100 text-red-600 px-4 py-2 rounded">
        <ul class="list-disc ml-6 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif -->
    
<!-- Tom Select -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#author_ids', {
        plugins: ['remove_button'],
        maxItems: null,
        placeholder: 'Nhấn để chọn tác giả...',
        create: false,
        persist: false,
    });
</script>
@endsection

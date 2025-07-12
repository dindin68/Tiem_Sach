@extends('admin.layouts.app')

@section('content')



<div class="container mx-auto p-4 max-w-3xl">
    <h1 class="text-2xl font-bold text-blue-600 mb-6">Chỉnh sửa sách</h1>

    <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Mã sách -->
            <div>
                <label for="id" class="block text-gray-700">Mã sách</label>
                <input type="text" id="id" value="{{ $book->id }}" disabled
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Danh mục -->
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Danh mục</label>
                <select name="category_id" id="category_id" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tiêu đề -->
            <div class="md:col-span-2">
                <label for="title" class="block text-gray-700">Tiêu đề</label>
                <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('title')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nhà xuất bản --}}
            <div>
                <label for="publisher" class="block text-gray-700">Nhà xuất bản</label>
                <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('publisher')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Giá --}}
            <div>
                <label for="price" class="block text-gray-700">Giá</label>
                <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $book->price) }}"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('price')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>



            {{-- Tác giả --}}
            <div class="md:col-span-2">
                <label for="author_ids" class="block text-gray-700">Tác giả</label>
                <select name="author_ids[]" id="author_ids" multiple
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}"
                            {{ in_array($author->id, old('author_ids', $book->authors->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
                @error('author_ids')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Hình ảnh --}}
             <div class="md:col-span-2">
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

        </div>

        <div class="mt-6">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Cập nhật sách</button>
        </div>
    </form>
</div>

{{-- TomSelect --}}
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#author_ids', {
        plugins: ['remove_button'],
        placeholder: 'Chọn tác giả...',
        maxItems: null,
    });
</script>
@endsection

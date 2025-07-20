@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
        <h1 class="text-2xl font-bold text-blue-700 mb-6 text-center">Chỉnh sửa thông tin sách</h1>

        <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Mã sách -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mã sách</label>
                    <input type="text" value="{{ $book->id }}" disabled
                        class="w-full bg-gray-100 p-2 rounded-lg border border-gray-300 cursor-not-allowed text-gray-600">
                </div>

                <!-- Danh mục -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id"
                        class="w-full p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tiêu đề -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                        class="w-full p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nhà xuất bản -->
                <div>
                    <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Nhà xuất bản <span class="text-red-500">*</span></label>
                    <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}"
                        class="w-full p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" required>
                    @error('publisher')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Giá -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Giá <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $book->price) }}"
                        class="w-full p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tác giả -->
                <div class="md:col-span-2">
                    <label for="author_ids" class="block text-sm font-medium text-gray-700 mb-1">Tác giả <span class="text-red-500">*</span></label>
                    <select name="author_ids[]" id="author_ids" multiple
                        class="w-full p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" required>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}"
                                {{ in_array($author->id, old('author_ids', $book->authors->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_ids')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hình ảnh -->
                <div class="md:col-span-2">
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh</label>
                    <input type="file" name="images[]" id="images" multiple
                        class="w-full p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500">
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit button -->
            <div class="text-center">
                <button type="submit"
                    class="inline-flex items-center bg-blue-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Cập nhật sách
                </button>
            </div>
        </form>
    </div>
</div>

<!-- TomSelect -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#author_ids', {
        plugins: ['remove_button'],
        placeholder: 'Chọn tác giả...',
        persist: false,
        create: false
    });
</script>
@endsection

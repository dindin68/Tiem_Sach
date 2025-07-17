<!-- resources/views/admin/promotions/edit.blade.php -->
@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-4">Chỉnh sửa khuyến mãi</h2>

    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" class="max-w-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="id" class="block text-gray-700 font-semibold">Mã khuyến mãi</label>
            <input type="text" name="id" id="id"
                value="{{ $promotion->id }}"
                readonly
                class="w-full p-2 border rounded bg-gray-100 text-gray-700 cursor-not-allowed focus:outline-none focus:ring-0"
            >
        </div>


        <div class="mb-4">
            <label for="discount_percentage" class="block text-gray-700">Giảm giá (%)</label>
            <input type="number" name="discount_percentage" id="discount_percentage" step="0.01" value="{{ old('discount_percentage', $promotion->discount_percentage) }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('discount_percentage')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-gray-700">Ngày bắt đầu</label>
            <input type="date" name="start_date" id="start_date" 
                value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('start_date')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="end_date" class="block text-gray-700">Ngày kết thúc</label>
            <input type="date" name="end_date" id="end_date"
                value="{{ old('end_date', $promotion->end_date->format('Y-m-d')) }}"
                class="w-full p-2 border rounded" required>      
            @error('end_date')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="books" class="block text-gray-700">Chọn sách áp dụng</label>
            <select name="books[]" id="books" multiple class="tom-select w-full">
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" {{ in_array($book->id, $selectedBooks) ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>
            @error('books')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cập nhật khuyến mãi
        </button>
    </form>
</div>

<!-- TomSelect CSS + JS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect("#books", {
        plugins: ['remove_button'],
        placeholder: "Chọn sách...",
        persist: false,
        maxItems: null,
        create: false
    });
</script>

@endsection
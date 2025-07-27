@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-8 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl text-center font-bold text-green-700 mb-6"> Chỉnh sửa khuyến mãi</h2>

    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}">
        @csrf
        @method('PUT')

        <!-- Mã khuyến mãi (readonly) -->
        <div class="mb-4">
            <label for="id" class="block text-sm font-medium text-gray-700">Mã khuyến mãi</label>
            <input type="text" id="id" name="id" value="{{ $promotion->id }}" readonly
                   class="w-full mt-1 p-2 bg-gray-100 text-gray-600 border border-gray-300 rounded focus:outline-none cursor-not-allowed" />
        </div>

        <!-- Giảm giá -->
        <div class="mb-4">
            <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Giảm giá (%)</label>
            <input type="number" step="0.01" name="discount_percentage" id="discount_percentage"
                   value="{{ old('discount_percentage', $promotion->discount_percentage) }}"
                   class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            @error('discount_percentage')
                <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Ngày bắt đầu -->
        <div class="mb-4">
            <label for="start_date" class="block text-sm font-medium text-gray-700">Ngày bắt đầu</label>
            <input type="date" name="start_date" id="start_date"
                   value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}"
                   class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            @error('start_date')
                <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Ngày kết thúc -->
        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700">Ngày kết thúc</label>
            <input type="date" name="end_date" id="end_date"
                   value="{{ old('end_date', $promotion->end_date->format('Y-m-d')) }}"
                   class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            @error('end_date')
                <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Chọn sách áp dụng -->
        <div class="mb-6">
            <label for="books" class="block text-sm font-medium text-gray-700 mb-1">Chọn sách áp dụng</label>
            <select name="books[]" id="books" multiple class="w-full">
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" {{ in_array($book->id, $selectedBooks) ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>
            @error('books')
                <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit -->
        <div class="text-right">
            <button type="submit"
                class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded shadow-sm transition">
                 Cập nhật
            </button>
        </div>
    </form>
</div>

<!-- TomSelect CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect("#books", {
        plugins: ['remove_button'],
        placeholder: "Chọn sách...",
        persist: false,
        maxItems: null,
        create: false,
        render: {
            item: function(data, escape) {
                return '<div class="text-sm bg-blue-100 text-blue-700 px-2 py-1 rounded mr-1">' + escape(data.text) + '</div>';
            }
        }
    });
</script>
@endsection

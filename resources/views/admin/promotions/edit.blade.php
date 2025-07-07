<!-- resources/views/admin/promotions/edit.blade.php -->
@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-4">Chỉnh sửa khuyến mãi</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" class="max-w-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="code" class="block text-gray-700">Mã khuyến mãi</label>
            <input type="text" name="code" id="code" value="{{ old('code', $promotion->code) }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('code')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Tên khuyến mãi</label>
            <input type="text" name="name" id="name" value="{{ old('name', $promotion->name) }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="discount" class="block text-gray-700">Giảm giá (%)</label>
            <input type="number" name="discount" id="discount" step="0.01" value="{{ old('discount', $promotion->discount) }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('discount')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-gray-700">Ngày bắt đầu</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $promotion->start_date) }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('start_date')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="end_date" class="block text-gray-700">Ngày kết thúc</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $promotion->end_date) }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('end_date')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="books" class="block text-gray-700">Chọn sách áp dụng</label>
            <select name="books[]" id="books" multiple class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
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
@endsection
@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4 max-w-md">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">Thêm khuyến mãi</h1>
    <form method="POST" action="{{ route('admin.promotions.store') }}">
        @csrf
        <div class="mb-4">
            <label for="id" class="block text-gray-700">Mã khuyến mãi</label>
            <input type="text" name="id" id="id" value="{{ old('id') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="discount_percentage" class="block text-gray-700">Giảm giá (%)</label>
            <input type="number" name="discount_percentage" id="discount_percentage" step="0.01" value="{{ old('discount_percentage') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('discount_percentage')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="start_date" class="block text-gray-700">Ngày bắt đầu</label>
            <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('start_date')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="end_date" class="block text-gray-700">Ngày kết thúc</label>
            <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('end_date')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Thêm khuyến mãi</button>
    </form>
</div>
@endsection
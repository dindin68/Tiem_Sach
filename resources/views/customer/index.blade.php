@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Banner hoặc phần quảng cáo -->
    <div class="w-full mb-8">
        <img src="{{ asset('images/banner.jpg') }}" alt="Banner sách" class="rounded shadow w-full">
    </div>

    <!-- Mục tiêu đề -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sách mới phát hành</h2>

    <!-- Grid hiển thị sách -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
        @foreach ($books as $book)
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition duration-300 overflow-hidden">
            <img src="{{ asset('storage/covers/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-md font-semibold truncate">{{ $book->title }}</h3>
                <p class="text-sm text-gray-600 mb-1 truncate">{{ $book->author }}</p>
                <p class="text-red-500 font-bold mb-3">{{ number_format($book->price, 2) }} USD</p>
                <a href="{{ route('cart.add', $book->id) }}"
                   class="block text-center bg-blue-500 text-white py-1 rounded hover:bg-blue-600 transition">
                    Thêm vào giỏ
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

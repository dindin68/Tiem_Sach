@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Banner hoặc phần quảng cáo -->
    <div class="w-full mb-8">
        <img src="{{ asset('storage/uploads/banner.png') }}" alt="Banner sách" class="rounded shadow w-full">
    </div>

    <!-- Mục tiêu đề -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sách mới phát hành</h2>

    <!-- Grid hiển thị sách -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
    @foreach ($books as $book)
        <div class="bg-white rounded-md shadow hover:shadow-lg transition duration-300 overflow-hidden group">
            @if ($book->images->first())
                <div class="p-2 overflow-hidden flex justify-center">
                    <img src="{{ Storage::url($book->images->first()->path) }}" 
                         alt="{{ $book->title }}"
                         class="w-auto h-52 object-cover rounded-md transition duration-300 ease-in-out group-hover:scale-105 group-hover:brightness-110">
                </div>
            @else
                <div class="w-full h-52 bg-gray-100 flex items-center justify-center text-gray-400 text-sm rounded-md">
                    No Image
                </div>
            @endif

            <div class="p-3 text-center">
                <h3 class="text-sm font-semibold leading-5 line-clamp-2 h-10">{{ $book->title }}</h3>
                <p class="text-xs text-gray-500 truncate">{{ $book->author }}</p>
                <p class="text-red-500 font-semibold text-sm mt-2 mb-3">{{ number_format($book->price, 0) }} VND</p>

                <div class="flex justify-center gap-2">
                    <a href="{{ route('cart.add', $book->id) }}"
                       class="bg-blue-500 text-white text-sm px-3 py-1 rounded-md hover:bg-blue-600 transition duration-300">
                        Thêm vào giỏ
                    </a>
                    <a href="{{ route('cart.add', $book->id) }}"
                       class="bg-blue-500 text-white text-sm px-3 py-1 rounded-md hover:bg-blue-600 transition duration-300">
                        Mua ngay
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>



</div>
@endsection

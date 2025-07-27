@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        {{-- Banner --}}
        <div class="w-full mb-8">
            <img src="{{ asset('storage/uploads/banner.png') }}" alt="Banner"
                class="w-full h-auto object-cover rounded-xl shadow-md">
        </div>

        {{-- Tiêu đề --}}
        <h2 class="text-3xl text-center text-green-700 mb-8">
            Tủ Sách {{ $categoryName ? '- ' . $categoryName : '' }}
        </h2>

        {{-- Lưới sách --}}
        @if($books->count())
            <x-book-grid :books="$books" />

            {{-- Phân trang --}}
            <div class="mt-10 flex justify-center">
                {{ $books->links() }}
            </div>
        @else
            <p class="text-center text-gray-500 text-lg mt-10">Không tìm thấy sách nào.</p>
        @endif

    </div>
@endsection
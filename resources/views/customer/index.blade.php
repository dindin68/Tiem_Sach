@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 space-y-10">

        {{-- Carousel --}}
        <div class="w-full h-auto rounded-2xl overflow-hidden shadow-xl">
            <x-carousel />
        </div>

        {{-- Sách mới phát hành --}}
        @if($newBooks->count())
            <div class="animate-fade-in">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sách mới phát hành</h2>
                <x-book-grid :books="$newBooks" />
            </div>
        @endif

        {{-- Sách đang khuyến mãi --}}
        @if($discountedBooks->count())
            <div class="animate-fade-in">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 mt-8">Sách đang khuyến mãi</h2>
                <x-book-grid :books="$discountedBooks" />
            </div>
        @endif

        {{-- Sách bán chạy --}}
        @if($popularBooks->count())
            <div class="animate-fade-in">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 mt-8">Sách bán chạy</h2>
                <x-book-grid :books="$popularBooks" />
            </div>
        @endif

    </div>
@endsection
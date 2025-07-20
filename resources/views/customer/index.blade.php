@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="w-full mb-8 h-auto">
        <x-carousel />
    </div>

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sách mới phát hành</h2>
    <x-book-grid :books="$newBooks" />

    <h2 class="text-2xl font-semibold text-gray-800 mb-4 mt-8">Sách đang khuyến mãi</h2>
    <x-book-grid :books="$discountedBooks" />

</div>
@endsection

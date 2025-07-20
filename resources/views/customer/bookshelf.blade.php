@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-green-700 mb-4">
        Thể loại: {{ $selectedCategory->name }}
    </h1>

    @if($books->isEmpty())
        <p class="text-gray-500">Không có sách nào trong thể loại này.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($books as $book)
                <div class="border rounded-lg shadow hover:shadow-lg transition p-4">
                    <h3 class="font-semibold text-lg text-gray-800">{{ $book->title }}</h3>
                    <p class="text-sm text-gray-600">Tác giả: {{ $book->author->name ?? 'Không rõ' }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($book->description, 100) }}</p>
                    <a href="{{ route('books.show', $book->id) }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Xem chi tiết</a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $books->links() }}
        </div>
    @endif
</div>
@endsection

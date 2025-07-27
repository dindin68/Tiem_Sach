@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-xl font-semibold mb-4">Kết quả tìm kiếm cho: "{{ $query }}"</h2>

        {{-- Kết quả sách --}}
        @if($books->count())
            <h3 class="text-lg font-bold mt-6 mb-2">Sách</h3>
            <x-book-grid :books="$books" />
        @else
            <p class="text-center text-gray-500 mt-4">Không tìm thấy sách phù hợp.</p>
        @endif

        {{-- Kết quả tác giả --}}
        @if ($authors->count())
            <h3 class="text-lg font-bold mt-8 mb-4">Tác giả</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($authors as $author)
                    <div class="text-center">
                        <a href="{{ route('customer.authors_show', $author->id) }}">
                            <div class="w-24 h-24 mx-auto rounded-full overflow-hidden shadow hover:scale-105 transition">
                                @if ($author->photo)
                                    <img src="{{ asset('storage/' . $author->photo) }}" alt="{{ $author->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-600 text-lg">
                                        <span>{{ \Illuminate\Support\Str::limit($author->name, 1, '') }}</span>
                                    </div>
                                @endif
                            </div>
                            <p class="mt-2 font-medium text-sm text-green-700 hover:underline">{{ $author->name }}</p>
                        </a>
                        <p class="text-xs text-gray-500">({{ $author->books->count() }} sách)</p>
                    </div>

                @endforeach
            </div>
        @endif

        {{-- Nếu không có gì --}}
        @if ($books->isEmpty() && $authors->isEmpty())
            <p class="italic text-gray-500">Không tìm thấy kết quả phù hợp.</p>
        @endif
    </div>
@endsection
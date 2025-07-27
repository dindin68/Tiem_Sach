@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-6 text-center">Tất cả Tác giả</h2>

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
        <div class="mt-6">
            {{ $authors->links() }}
        </div>
    </div>


@endsection
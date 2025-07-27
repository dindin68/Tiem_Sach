@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-10">
        <div class="w-32 h-32 rounded-full overflow-hidden shadow">
            @if ($author->photo)
                <img src="{{ asset('storage/' . $author->photo) }}" alt="{{ $author->name }}"
                    class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-600 text-lg">
                    <span>{{ \Illuminate\Support\Str::limit($author->name, 1, '') }}</span>
                </div>
            @endif
        </div>
        <div>
            <h2 class="text-2xl font-bold text-green-700">{{ $author->name }}</h2>
            <p class="mt-2 text-gray-700 leading-relaxed">
                {!! nl2br(e($author->infor ?? 'Không có thông tin.')) !!}
            </p>
        </div>
    </div>

    {{-- Grid sách của tác giả --}}
    @if ($author->books->count())
        <h3 class="text-xl font-semibold mb-4">Tác phẩm</h3>
        <x-book-grid :books="$author->books" />
    @else
        <p class="italic text-gray-500">Cửa hàng chưa có sách của tác giả.</p>
    @endif
</div>
@endsection

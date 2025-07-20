<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
    @foreach ($books as $book)
        <div x-data="{ open: false }"
            class="bg-white rounded-md shadow hover:shadow-lg transition duration-300 overflow-hidden group flex flex-col">

            {{-- Ảnh sách --}}
            @if ($book->images->first())
                <div @click="open = true" class="relative p-2 overflow-hidden flex justify-center">
                    @if ($book->is_discounted)
                        <div
                            class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded shadow z-10">
                            -{{ round(100 * (1 - $book->discounted_price / $book->price)) }}%
                        </div>
                    @endif
                    <img src="{{ Storage::url($book->images->first()->path) }}" alt="{{ $book->title }}"
                        class="w-auto h-52 object-cover rounded-md transition duration-300 ease-in-out group-hover:scale-105 group-hover:brightness-110">
                </div>
            @else
                <div class="w-full h-52 bg-gray-100 flex items-center justify-center text-gray-400 text-sm rounded-md">
                    No Image
                </div>
            @endif

            {{-- Nội dung --}}
            <div class="p-3 text-center flex flex-col flex-grow">
                <h3 class="text-sm font-semibold leading-5 line-clamp-2 h-10">{{ $book->title }}</h3>
                <p class="text-xs text-gray-500 truncate">{{ $book->authors->pluck('name')->join(' & ') }}</p>
                <p class="text-red-500 font-semibold text-sm mt-2 mb-3">
                    @if ($book->is_discounted)
                        <div class="flex flex-row justify-center">
                            <div class="text-red-600 text-sm mx-2">{{ number_format($book->discounted_price) }}</div>
                            <div class="text-gray-500 line-through mx-2 text-sm">{{ number_format($book->price) }}</div>
                        </div>
                    @else
                    {{ number_format($book->price) }}
                @endif
                </p>

                <div class="flex justify-center gap-2 mt-auto">
                    <a href="#"
                        class="bg-blue-500 text-white text-sm px-3 py-1 rounded-md hover:bg-blue-600 transition duration-300 shadow">
                        Mua ngay
                    </a>

                    <button @click="open = true"
                        class="bg-blue-500 text-white text-sm px-3 py-1 rounded-md hover:bg-blue-600 transition duration-300 shadow">
                        Thêm vào giỏ
                    </button>
                </div>
            </div>

            <x-book-modal :book="$book" />
        </div>
    @endforeach
</div>
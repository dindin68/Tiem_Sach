<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
    @foreach ($books as $book)
        <div x-data="{ open: false }"
            class="bg-white rounded-md shadow hover:shadow-lg 
                transition duration-300 overflow-hidden group 
                flex flex-col">

            {{-- Ảnh sách --}}
            @if ($book->images->first())
                <div @click="open = true" class="relative p-2 overflow-hidden flex justify-center">
                    @if ($book->discounted_price)
                        <div
                            class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded shadow z-10">
                            -{{ round(100 * (1 - $book->discounted_price / $book->price)) }}%
                        </div>
                    @endif
                    <img src="{{ Storage::url($book->images->first()->path) }}" alt="{{ $book->title }}"
                        class="w-auto h-52 object-cover rounded-md transition duration-300 ease-in-out group-hover:scale-105 group-hover:brightness-110">
                </div>
            @else
                <div class="w-full my-2 p-4 h-52 bg-gray-100 flex items-center justify-center text-gray-400 text-sm rounded-md">
                    No Image
                </div>
            @endif

            {{-- Nội dung --}}
            <div class="p-3 text-center flex flex-col flex-grow">

                {{-- Tiêu đề sách --}}
                <h3 class="text-sm font-semibold leading-5 line-clamp-2 min-h-[2.5rem]">
                    {{ $book->title }}
                </h3>

                {{-- Tác giả --}}
                <p class="text-xs text-gray-500 truncate  min-h-[2rem]">
                    {{ $book->authors->pluck('name')->join(' & ') }}
                </p>

                {{-- Giá --}}
                <div class="mt-3 mb-3">
                    @if ($book->discounted_price)
                        <div class="text-gray-500 text-sm line-through">{{ number_format($book->price) }} đ</div>
                        <div class="text-red-600 font-semibold text-base">{{ number_format($book->discounted_price) }} đ</div>
                    @else
                        <div class="text-gray-800 font-semibold text-base">{{ number_format($book->price) }} đ</div>
                    @endif
                </div>

                {{-- Nút hành động --}}
                <div class="flex justify-center gap-2 mt-auto">


                    <button @click="open = true"
                        class="bg-blue-500 text-white text-sm px-3 py-1 rounded-md hover:bg-blue-600 transition duration-300 shadow">
                        Thêm vào giỏ
                    </button>
                </div>
            </div>

            {{-- Modal chi tiết --}}
            <x-book-modal :book="$book" />
        </div>
    @endforeach
</div>

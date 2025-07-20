<div>
    <!-- resources/views/components/book-modal.blade.php -->
    <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200">
        <div class="bg-white w-full max-w-3xl p-6 rounded-xl shadow-lg relative flex flex-col md:flex-row gap-6">
            <!-- Nút đóng -->
            <button class="absolute top-3 right-4 text-gray-600 hover:text-red-500 text-2xl"
                @click="open = false">&times;</button>

            <!-- BÊN TRÁI: ẢNH -->
            <div class="md:w-1/3 flex items-center justify-center">
                @if ($book->images->first())
                    <img src="{{ Storage::url($book->images->first()->path) }}" alt="{{ $book->title }}"
                        class="rounded-md object-contain max-h-80 w-full">
                @else
                    <div class="w-16 h-16 bg-gray-200 flex items-center justify-center">No Image</div>
                @endif
            </div>

            <!-- BÊN PHẢI: THÔNG TIN -->
            <div class="md:w-2/3">
                <h2 class="text-xl font-semibold text-gray-800 mb-1">{{ $book->title }}</h2>
                <p class="text-sm text-gray-500 mb-1">Tác giả: {{ $book->authors->pluck('name')->join(', ') }}</p>
                <p class="text-sm text-gray-500 mb-4">Nhà xuất bản: {{ $book->publisher ?? 'Không rõ' }}</p>

                <div class="mb-4">
                    @if ($book->is_discounted)
                        <div class="flex gap-2 items-center">
                            <span class="text-xl font-bold text-red-600">{{ number_format($book->discounted_price) }}
                                đ</span>
                            <span class="text-base text-gray-400 line-through">{{ number_format($book->price) }} đ</span>
                        </div>
                    @else
                        <span class="text-xl font-bold text-red-600">{{ number_format($book->price) }} đ</span>
                    @endif
                </div>

                <!-- FORM CHỌN SỐ LƯỢNG -->
                <form method="POST" action="{{ route('cart.add', $book->id) }}">
                    @csrf
                    <label class="block font-medium text-sm mb-2">Số lượng:</label>
                    <div class="flex items-center border rounded w-36 overflow-hidden mb-4">
                        <button type="button"
                            class="w-10 h-10 bg-gray-100 hover:bg-gray-200 flex items-center justify-center"
                            @click="$refs.qty.value = Math.max(1, parseInt($refs.qty.value) - 1)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 448 512">
                                <path
                                    d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z" />
                            </svg>
                        </button>

                        <input x-ref="qty" name="quantity" type="number" min="1" value="1"
                            class="no-spinner w-16 text-center border-0 focus:outline-none">

                        <button type="button"
                            class="w-10 h-10 bg-gray-100 hover:bg-gray-200 flex items-center justify-center"
                            @click="$refs.qty.value = parseInt($refs.qty.value) + 1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 448 512">
                                <path
                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z" />
                            </svg>
                        </button>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium shadow">
                        Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
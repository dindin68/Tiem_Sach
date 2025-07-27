<!-- Modal -->
<div x-data="bookModal()" x-show="open" x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
    x-transition:enter="transition ease-out duration-300"
    x-transition:leave="transition ease-in duration-200">

    <div class="bg-white w-full max-w-3xl p-6 rounded-xl shadow-xl relative flex flex-col md:flex-row gap-6">
        <!-- Nút đóng -->
        <button class="absolute top-3 right-4 text-gray-500 hover:text-red-600 text-2xl font-bold"
            @click="open = false">&times;</button>

        <!-- Ảnh sách -->
        <div class="md:w-1/3 flex items-center justify-center">
            @if ($book->images->first())
                <img src="{{ Storage::url($book->images->first()->path) }}"
                     alt="{{ $book->title }}"
                     class="rounded-lg object-contain max-h-72 w-full">
            @else
                <div class="w-28 h-28 bg-gray-200 flex items-center justify-center rounded">No Image</div>
            @endif
        </div>

        <!-- Thông tin sách -->
        <div class="md:w-2/3 space-y-4">
            <h2 class="text-2xl font-semibold text-gray-800">{{ $book->title }}</h2>

            <!-- Số lượng -->
            <div>
                <label class="block font-medium text-sm text-gray-600 mb-1">Số lượng</label>
                <div class="flex items-center border rounded w-36 overflow-hidden shadow-sm">
                    <button type="button"
                            class="w-10 h-10 bg-gray-100 hover:bg-gray-200 flex items-center justify-center"
                            @click="decreaseQty">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 448 512">
                            <path d="M432 256c0 17.7-14.3 32-32 32H48c-17.7 0-32-14.3-32-32s14.3-32 32-32h352c17.7 0 32 14.3 32 32z"/>
                        </svg>
                    </button>

                    <input type="number" min="1"
                           class="no-spinner w-16 text-center border-0 focus:outline-none"
                           :value="quantity"
                           @input="syncQtyInput($event)">

                    <button type="button"
                            class="w-10 h-10 bg-gray-100 hover:bg-gray-200 flex items-center justify-center"
                            @click="increaseQty">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 448 512">
                            <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Hành động -->
            <div class="flex flex-wrap gap-3 mt-2">
                <!-- Mua ngay -->
                <form action="{{ route('checkout.buy-now') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="hidden" name="quantity" :value="quantity">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow text-sm">
                        Mua ngay
                    </button>
                </form>

                <!-- Thêm vào giỏ -->
                <form method="POST" action="{{ route('cart.add', $book->id) }}">
                    @csrf
                    <input type="hidden" name="quantity" :value="quantity">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
                        Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- AlpineJS logic -->
<script>
    function bookModal() {
        return {
            quantity: 1,
            increaseQty() {
                this.quantity++;
            },
            decreaseQty() {
                if (this.quantity > 1) {
                    this.quantity--;
                }
            },
            syncQtyInput(event) {
                const val = parseInt(event.target.value);
                this.quantity = isNaN(val) || val < 1 ? 1 : val;
            }
        }
    }
</script>

@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">🛒 Giỏ hàng</h1>

        @if($items->isEmpty())
            <p class="text-gray-600">Chưa có sản phẩm nào trong giỏ hàng.</p>
        @else
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase text-center">
                        <tr>
                            <th class="px-4 py-3"></th>
                            <th class="px-4 py-3">Sách</th>
                            <th class="px-4 py-3">Đơn giá</th>
                            <th class="px-4 py-3">Số lượng</th>
                            <th class="px-4 py-3">Thành tiền</th>
                            <th class="px-4 py-3">Xóa</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items ">
                        @foreach($items as $item)

                            <tr data-id="{{ $item->book_id }}" class="border-b text-center">
                                <td class="px-4 py-3 flex justify-center">

                                    <img src="{{ $item->image_url }}" alt="{{ $item->book->title }}"
                                        class="w-20 h-28 object-cover mr-4 ">
                                </td>
                                <td class="px-4 py-3">
                                    {{ $item->book->title }}
                                </td>
                                <td class="px-4 py-3">{{ number_format($item->unit_price) }}₫</td>
                                <td class="px-4 py-3">
                                    <input type="number" class="qty-input border rounded w-16 text-center" min="1"
                                        value="{{ $item->quantity }}" data-id="{{ $item->book_id }}">
                                </td>
                                <td class="px-4 py-3 sub-total">{{ number_format($item->amount) }}₫</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right">Tổng cộng:</td>
                            <td class="px-4 py-3" id="total-amount">
                                {{ number_format($items->sum(fn($i) => $i->amount)) }}₫
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/customer/cart.js') }}"></script>
@endsection
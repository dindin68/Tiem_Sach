@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl mb-6 text-center">🧾 Xác nhận đơn hàng</h1>

        @if($items->isEmpty())
            <p class="text-gray-600">Bạn chưa có sản phẩm nào để thanh toán.</p>
        @else
            <h2 class="text-lg font-semibold mb-2">Địa chỉ giao hàng</h2>

            <form action="{{ route('checkout.process') }}" method="POST" class="space-y-2 mb-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="recipient_name" class="block">Người nhận:</label>
                        <input type="text" id='recipient_name' name="recipient_name" class="w-full border px-2 py-1" required>
                    </div>
                    <div>
                        <label for="phone" class="block">Số điện thoại:</label>
                        <input type="text" id='phone' name="phone" class="w-full border px-2 py-1" required>
                    </div>
                    <div>
                        <label for="house_number" class="block">Số nhà:</label>
                        <input type="text" id='house_number' name="house_number" class="w-full border px-2 py-1" required>
                    </div>
                    <div>
                        <label for="ward" class="block">Phường:</label>
                        <input type="text" id='ward' name="ward" class="w-full border px-2 py-1" required>
                    </div>
                    <div>
                        <label for="district" class="block">Quận/Huyện:</label>
                        <input type="text" id="district" name="district" class="w-full border px-2 py-1" required>
                    </div>
                    <div>
                        <label for="city" class="block">Thành phố:</label>
                        <input type="text" name="city" id="city" class="w-full border px-2 py-1" required>
                    </div>
                </div>
                <div class="flex items-center gap-x-4">
                    <label for="payment_method" class="whitespace-nowrap font-medium text-gray-700">
                        💳 Phương thức thanh toán:
                    </label>
                    <select name="payment_method" id="payment_method" class="flex-1 border px-2 py-1 rounded w-full max-w-sm"
                        required>
                        <option value="">-- Chọn phương thức --</option>
                        @foreach($paymentMethods as $name)
                            <option value="{{ $name->id }}">{{ $name->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Hiển thị bảng sản phẩm --}}
                <div class="bg-white shadow rounded-lg overflow-x-auto mt-6">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase text-center">
                            <tr>
                                <th class="px-4 py-3">Sách</th>
                                <th class="px-4 py-3">Số lượng</th>
                                <th class="px-4 py-3">Đơn giá</th>
                                <th class="px-4 py-3">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr class="border-b text-center">
                                    <td class="px-4 py-3">
                                        {{ $item->book->title }}</td>
                                    <td class="px-4 py-3">
                                        {{ $item->quantity }}</td>
                                    <td class="px-4 py-3">
                                        {{ number_format($item->unit_price) }}₫</td>
                                    <td class="px-4 py-3">
                                        {{ number_format($item->amount) }}₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-semibold">


                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right">Tổng tiền sản phẩm:</td>
                                <td class="px-4 py-3" id="total-amount" data-amount="{{ $total }}">{{ number_format($total) }}₫
                                </td>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right">Phí giao hàng:</td>
                                <td class="px-4 py-3" id="shipping-fee-display">Chưa xác định</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right">Tổng thanh toán:</td>
                                <td class="px-4 py-3" id="grand-total">Chưa xác định</td>
                            </tr>
                        </tfoot>

                    </table>
                </div>

                {{-- Nút xác nhận --}}
                <div class="mt-6 text-right">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        Xác nhận thanh toán
                    </button>
                </div>
                <input type="hidden" name="shipping_fee" id="shipping_fee">
            </form>

        @endif
    </div>
@endsection

@section('scripts')
    <script>
        // ✅ Hàm format tiền
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + '₫';
        }

        // ✅ Hàm tính và cập nhật phí ship
        window.updateShippingAndTotal = function () {
            const city = document.getElementById('city')?.value.trim().toLowerCase() || '';
            const district = document.getElementById('district')?.value.trim().toLowerCase() || '';
            const total = parseInt(document.getElementById('total-amount')?.dataset.amount) || 0;

            let shippingFee = 0;
            if (city.includes('cần thơ') || district.includes('cần thơ')) {
                shippingFee = 15000;
            } else if (city || district) {
                shippingFee = 30000;
            }

            // ✅ Cập nhật giao diện
            document.getElementById('shipping-fee-display').innerText = formatCurrency(shippingFee);
            document.getElementById('grand-total').innerText = formatCurrency(total + shippingFee);
            document.getElementById('shipping_fee').value = shippingFee;
        }

        // ✅ Gán sự kiện sau khi DOM load
        document.addEventListener('DOMContentLoaded', function () {
            // Gán sự kiện input cho city + district
            ['city', 'district'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    ['input', 'change', 'keyup'].forEach(evt => {
                        el.addEventListener(evt, updateShippingAndTotal);
                    });
                }
            });

            // ✅ Gọi hàm 1 lần để cập nhật khi vừa load trang
            updateShippingAndTotal();
        });
    </script>
@endsection
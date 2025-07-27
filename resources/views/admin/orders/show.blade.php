@extends('admin.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Chi tiết đơn hàng #{{ $order->id }}</h2>

    <!-- Thông tin đơn hàng -->
    <div class="bg-white shadow rounded-lg p-6 mb-8 space-y-2 text-gray-700 text-sm">
        <div><span class="font-semibold">Khách hàng:</span> {{ $order->customer->name }}</div>
        <div><span class="font-semibold">Ngày đặt:</span> {{ $order->date_order->format('d/m/Y H:i') }}</div>
        <div><span class="font-semibold">Phương thức thanh toán:</span> {{ $order->paymentMethod->name ?? 'Không rõ' }}</div>
        <div><span class="font-semibold">Phí vận chuyển:</span> {{ number_format($order->shipping_fee) }}₫</div>
        <div class="text-base">
            <span class="font-semibold">Tổng cộng:</span>
            <span class="text-green-700 font-bold text-lg">{{ number_format($order->total_cost) }}₫</span>
        </div>
    </div>

    <!-- Form cập nhật trạng thái -->
    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="bg-white shadow rounded-lg p-6 mb-8">
        @csrf
        @method('PUT')

        <label for="status" class="block text-gray-700 font-medium mb-2">Trạng thái đơn hàng</label>
        <select id="status" name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 mb-4 focus:ring-green-500 focus:border-green-500">
            <option value="Đang chuẩn bị" {{ $order->status == 'Đang chuẩn bị' ? 'selected' : '' }}>Đang chuẩn bị</option>
            <option value="Đang vận chuyển" {{ $order->status == 'Đang vận chuyển' ? 'selected' : '' }}>Đang vận chuyển</option>
            <option value="Hoàn thành" {{ $order->status == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
            <option value="Hoàn trả" {{ $order->status == 'Hoàn trả' ? 'selected' : '' }}>Hoàn trả</option>
        </select>

        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-semibold px-4 py-2 rounded">
            Cập nhật trạng thái
        </button>
    </form>

    <!-- Danh sách sản phẩm -->
    <h3 class="text-xl font-semibold mb-4">Sản phẩm đã đặt</h3>
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left border-b">Sách</th>
                    <th class="px-4 py-3 text-right border-b">Đơn giá</th>
                    <th class="px-4 py-3 text-center border-b">Số lượng</th>
                    <th class="px-4 py-3 text-right border-b">Tạm tính</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @php $subtotal = 0; @endphp
                @foreach($order->items as $item)
                    @php $subtotal += $item->amount; @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $item->book->title }}</td>
                        <td class="px-4 py-2 text-right border-b">{{ number_format($item->unit_price) }}₫</td>
                        <td class="px-4 py-2 text-center border-b">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-right border-b">{{ number_format($item->amount) }}₫</td>
                    </tr>
                @endforeach
                <tr class="bg-gray-50 font-semibold">
                    <td colspan="3" class="px-4 py-2 text-right border-b">Tạm tính:</td>
                    <td class="px-4 py-2 text-right border-b">{{ number_format($subtotal) }}₫</td>
                </tr>
                <tr class="font-semibold">
                    <td colspan="3" class="px-4 py-2 text-right">Phí vận chuyển:</td>
                    <td class="px-4 py-2 text-right">{{ number_format($order->shipping_fee) }}₫</td>
                </tr>
                <tr class="font-bold text-green-700 text-lg">
                    <td colspan="3" class="px-4 py-2 text-right">Tổng cộng:</td>
                    <td class="px-4 py-2 text-right">{{ number_format($order->total_cost) }}₫</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 320 512">
                <path d="M96 256L224 384c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-128-128c-9.4-9.4-9.4-24.6 0-33.9l128-128c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L96 256z"/>
            </svg>
            Quay lại danh sách
        </a>
    </div>
</div>
@endsection

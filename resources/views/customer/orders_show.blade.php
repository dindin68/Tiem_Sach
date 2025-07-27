@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <h2 class="text-2xl sm:text-3xl text-indigo-800 mb-6">
        Chi tiết đơn hàng #{{ $order->id }}
    </h2>

    <!-- Thông tin đơn hàng -->
    <div class="bg-white shadow rounded-lg p-6 border mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm sm:text-base text-gray-700">
            <p>Ngày đặt: {{ \Carbon\Carbon::parse($order->date_order)->format('d/m/Y H:i') }}</p>
            <p>
                Trạng thái:
                <span class="inline-block px-2 py-1 rounded-full text-white
                    @if ($order->status === 'Chờ xử lý') bg-yellow-500
                    @elseif ($order->status === 'Đang giao') bg-blue-500
                    @elseif ($order->status === 'Đã giao') bg-green-600
                    @elseif ($order->status === 'Đã hủy') bg-red-500
                    @else bg-gray-400
                    @endif">
                    {{ $order->status }}
                </span>
            </p>
            <p>Phí vận chuyển: {{ number_format($order->shipping_fee) }}₫</p>
            <p>Tổng cộng:
                <span class="text-green-700 text-lg">{{ number_format($order->total_cost) }}₫</span>
            </p>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <h3 class="text-xl mb-4 text-gray-800">Sản phẩm đã đặt</h3>
    <div class="overflow-x-auto bg-white shadow border rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">Sách</th>
                    <th class="px-4 py-2 text-right">Đơn giá</th>
                    <th class="px-4 py-2 text-center">Số lượng</th>
                    <th class="px-4 py-2 text-right">Tạm tính</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100 text-gray-800">
                @foreach($order->items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $item->book->title }}</td>
                        <td class="px-4 py-2 text-right">{{ number_format($item->unit_price) }}₫</td>
                        <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-right">{{ number_format($item->amount) }}₫</td>
                    </tr>
                @endforeach
                <tr class="bg-gray-50">
                    <td colspan="3" class="px-4 py-2 text-right">Tạm tính:</td>
                    <td class="px-4 py-2 text-right">{{ number_format($order->items->sum('amount')) }}₫</td>
                </tr>
                <tr>
                    <td colspan="3" class="px-4 py-2 text-right">Phí vận chuyển:</td>
                    <td class="px-4 py-2 text-right">{{ number_format($order->shipping_fee) }}₫</td>
                </tr>
                <tr class="text-indigo-700 text-base">
                    <td colspan="3" class="px-4 py-2 text-right">Tổng cộng:</td>
                    <td class="px-4 py-2 text-right">{{ number_format($order->total_cost) }}₫</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Nút quay lại -->
    <div class="mt-8">
        <a href="{{ route('customer.orders') }}"
           class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-800 border border-gray-300 px-6 py-2 rounded-lg transition">
            ← Quay lại danh sách đơn hàng
        </a>
    </div>
</div>
@endsection

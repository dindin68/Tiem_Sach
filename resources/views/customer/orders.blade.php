@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4 sm:p-6">
    <h2 class="text-2xl sm:text-3xl text-indigo-800 mb-6">Đơn hàng</h2>

    @forelse($orders as $order)
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-4 p-5 hover:shadow-md transition">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 mb-3">
                <div class="text-gray-700">
                    <div><span class="font-medium">Mã đơn:</span> #{{ $order->id }}</div>
                    <div><span class="font-medium">Ngày đặt:</span> {{ \Carbon\Carbon::parse($order->date_order)->format('d/m/Y H:i') }}</div>
                    <div>
                        <span class="font-medium">Trạng thái:</span>
                        <span class="inline-block px-2 py-1 rounded-full text-white text-sm
                            @if ($order->status === 'Chờ xử lý') bg-yellow-500
                            @elseif ($order->status === 'Đang giao') bg-blue-500
                            @elseif ($order->status === 'Đã giao') bg-green-600
                            @elseif ($order->status === 'Đã hủy') bg-red-500
                            @else bg-gray-400
                            @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                    <div><span class="font-medium">Tổng cộng:</span> <span class="text-green-700">{{ number_format($order->total_cost) }}₫</span></div>
                </div>

                <div class="mt-3 md:mt-0">
                    <a href="{{ route('customer.orders_show', $order->id) }}"
                       class="inline-block bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-4 py-2 rounded border border-indigo-300 text-sm font-medium transition">
                        Xem chi tiết →
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="text-gray-500 text-center mt-12">
            Bạn chưa có đơn hàng nào.
        </div>
    @endforelse

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection

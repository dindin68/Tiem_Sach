@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">Bảng điều khiển quản trị</h1>
    <p class="text-gray-600 mb-6">Chào mừng bạn quay lại! Dưới đây là thống kê tổng quan.</p>

    <!-- Thống kê tổng quan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-blue-100 p-4 rounded shadow">
            <p class="text-sm text-gray-600">Tổng số sách</p>
            <h3 class="text-2xl font-bold text-blue-700">{{ $totalBooks }}</h3>
        </div>
        <div class="bg-green-100 p-4 rounded shadow">
            <p class="text-sm text-gray-600">Tổng đơn hàng</p>
            <h3 class="text-2xl font-bold text-green-700">{{ $totalOrders }}</h3>
        </div>
        <div class="bg-yellow-100 p-4 rounded shadow">
            <p class="text-sm text-gray-600">Doanh thu hôm nay</p>
            <h3 class="text-2xl font-bold text-yellow-700">{{ number_format($revenueToday) }}₫</h3>
        </div>
        <div class="bg-red-100 p-4 rounded shadow">
            <p class="text-sm text-gray-600">Đơn chưa xử lý</p>
            <h3 class="text-2xl font-bold text-red-700">{{ $pendingOrders }}</h3>
        </div>
    </div>

    <!-- Đơn hàng gần đây -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-3">5 Đơn hàng gần đây</h3>
        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Mã đơn</th>
                        <th class="px-4 py-2">Khách hàng</th>
                        <th class="px-4 py-2">Tổng tiền</th>
                        <th class="px-4 py-2">Trạng thái</th>
                        <th class="px-4 py-2">Ngày đặt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->customer->name }}</td>
                            <td class="px-4 py-2">{{ number_format($order->total_cost) }}₫</td>
                            <td class="px-4 py-2">{{ $order->status }}</td>
                            <td class="px-4 py-2">{{ $order->date_order->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500 italic">
                                Chưa có đơn hàng nào gần đây.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

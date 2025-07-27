@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Báo cáo Doanh thu</h2>

    <!-- Form lọc ngày -->
    <form method="GET" class="flex flex-wrap gap-4 items-end mb-6">
        <div>
            <label for="start_date" class="block text-sm">Từ ngày</label>
            <input type="date" name="start_date" value="{{ $start }}"
                   class="border rounded px-3 py-2">
        </div>
        <div>
            <label for="end_date" class="block text-sm">Đến ngày</label>
            <input type="date" name="end_date" value="{{ $end }}"
                   class="border rounded px-3 py-2">
        </div>
        <div>
            <button type="submit"
                    class="bg-green-800 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded mt-5">
                Lọc
            </button>
        </div>
    </form>

    <!-- Tổng doanh thu -->
    <div class="bg-green-100 text-green-800 px-6 py-4 rounded-lg shadow mb-6">
        <h4 class="text-lg font-semibold">Tổng doanh thu: {{ number_format($totalRevenue, 0, ',', '.') }}₫</h4>
    </div>

    <!-- Danh sách đơn -->
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Mã đơn</th>
                    <th class="px-4 py-2 border">Khách hàng</th>
                    <th class="px-4 py-2 border">Ngày đặt</th>
                    <th class="px-4 py-2 border text-right">Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $order->id }}</td>
                        <td class="px-4 py-2 border">{{ $order->customer->name ?? 'Không rõ' }}</td>
                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($order->date_order)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 border text-right">{{ number_format($order->total_cost) }}₫</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500 italic">Không có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

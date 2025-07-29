@extends('admin.layouts.app')

@section('content')
<div
    class="flex flex-col md:flex-row justify-between items-center bg-orange-50 border-l-4 border-green-700 rounded-lg shadow px-4 py-3 gap-4 md:gap-0">
    <h2 class="text-xl font-semibold text-green-900">Quản lý Tác giả</h2>
</div>

<form method="GET" class="mb-4 flex flex-wrap gap-4 items-end mt-4">
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái</label>
        <select name="status" id="status" class="border-gray-300 rounded-md shadow-sm">
            <option value="">-- Tất cả --</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Đang chuẩn bị" {{ request('status') == 'Đang chuẩn bị' ? 'selected' : '' }}>Đang chuẩn bị
            </option>
            <option value="Đang vận chuyển" {{ request('status') == 'Đang vận chuyển' ? 'selected' : '' }}>Đang vận chuyển
            </option>
            <option value="Hoàn thành" {{ request('status') == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
            <option value="Hoàn trả" {{ request('status') == 'Hoàn trả' ? 'selected' : '' }}>Hoàn trả</option>
        </select>
    </div>

    <div>
        <label for="date_from" class="block text-sm font-medium text-gray-700">Từ ngày</label>
        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
            class="border-gray-300 rounded-md shadow-sm">
    </div>

    <div>
        <label for="date_to" class="block text-sm font-medium text-gray-700">Đến ngày</label>
        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
            class="border-gray-300 rounded-md shadow-sm">
    </div>

    <div>
        <button type="submit" class="inline-block bg-green-700 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Lọc
        </button>
    </div>
</form>

<div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Mã đơn</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Khách hàng</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tổng tiền</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Ngày đặt</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Thanh toán</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Trạng thái</th>
                <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">Hành động</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($orders as $order)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->id }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->customer->name ?? 'Không rõ' }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($order->total_cost) }}₫</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->date_order->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->paymentMethod->name ?? 'Không rõ' }}</td>
                <td class="px-6 py-4 text-sm">
                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $order->status_color }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.orders.show', $order->id) }}"
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-md">
                        Xem
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-gray-500">
                    Không tìm thấy đơn hàng phù hợp.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection
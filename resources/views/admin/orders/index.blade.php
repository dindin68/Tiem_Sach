@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">Quản lý đơn hàng</h1>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Mã đơn</th>
                <th class="border p-2">Khách hàng</th>
                <th class="border p-2">Tổng tiền</th>
                <th class="border p-2">Trạng thái</th>
                <th class="border p-2">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td class="border p-2">{{ $order->id }}</td>
                <td class="border p-2">{{ $order->customer->name }}</td>
                <td class="border p-2">{{ number_format($order->total_cost, 2) }} USD</td>
                <td class="border p-2">{{ $order->status }}</td>
                <td class="border p-2">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <select name="status" onchange="this.form.submit()">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4 max-w-2xl">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">Xác nhận đơn hàng</h1>
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    <table class="w-full border-collapse mb-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Sách</th>
                <th class="border p-2">Số lượng</th>
                <th class="border p-2">Giá</th>
                <th class="border p-2">Tổng</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($cart as $id => $item)
            <tr>
                <td class="border p-2">{{ $item['title'] }}</td>
                <td class="border p-2">{{ $item['quantity'] }}</td>
                <td class="border p-2">{{ number_format($item['price'], 2) }} USD</td>
                <td class="border p-2">{{ number_format($item['price'] * $item['quantity'], 2) }} USD</td>
            </tr>
            @php $total += $item['price'] * $item['quantity']; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="border p-2 text-right font-bold">Tổng cộng:</td>
                <td class="border p-2 font-bold">{{ number_format($total, 2) }} USD</td>
            </tr>
        </tfoot>
    </table>
    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Xác nhận đặt hàng</button>
    </form>
</div>
@endsection
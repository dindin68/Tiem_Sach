@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl mb-6 text-center">🧾 Xác nhận đơn hàng</h1>

    @if($items->isEmpty())
        <p class="text-gray-600">Bạn chưa có sản phẩm nào để thanh toán.</p>
    @else
        <div class="bg-white shadow rounded-lg overflow-x-auto">
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
                            <td class="px-4 py-3">{{ $item->book->title }}</td>
                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                            <td class="px-4 py-3">{{ number_format($item->unit_price) }}₫</td>
                            <td class="px-4 py-3">{{ number_format($item->amount) }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 font-semibold">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right">Tổng cộng:</td>
                        <td class="px-4 py-3">{{ number_format($total) }}₫</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6 text-right">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                    Xác nhận thanh toán
                </button>
            </form>
        </div>
    @endif
</div>
@endsection

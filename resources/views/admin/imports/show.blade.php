@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto max-w-5xl p-6 bg-white shadow rounded-lg my-2">
    <!-- Tiêu đề -->
    <h1 class="text-2xl font-bold text-blue-700 mb-4">Chi tiết Phiếu Nhập #{{ $import->id }}</h1>
    
    <!-- Thông tin đơn nhập -->
    <div class="space-y-2 text-sm text-gray-700">
        <p><strong>Ngày nhập:</strong> {{ $import->date->format('d/m/Y H:i') }}</p>
        <p><strong>Nhà cung cấp:</strong> {{ $import->provider }}</p>
        <p><strong>Nhân viên nhập:</strong> {{ $import->admin->name ?? 'Admin' }}</p>
        <p><strong>Tổng tiền:</strong>
            <span class="text-green-700 font-semibold">{{ number_format($import->total_cost, 0, ',', '.') }} đ</span>
        </p>
    </div>

    <!-- Danh sách sách -->
    <h2 class="text-xl font-semibold mt-6 mb-3">Danh sách sách đã nhập</h2>

    <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
        <table class="min-w-full text-sm text-center">
            <thead class="bg-green-100 text-brown-800 uppercase">
                <tr>
                    <th class="border px-4 py-2">Tên sách</th>
                    <th class="border px-4 py-2">Số lượng</th>
                    <th class="border px-4 py-2">Giá nhập</th>
                    <th class="border px-4 py-2">Thành tiền</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($import->items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-left">{{ $item->book->title ?? 'Không tìm thấy' }}</td>
                        <td class="border px-4 py-2">{{ $item->quantity }}</td>
                        <td class="border px-4 py-2">{{ number_format($item->import_price, 0, ',', '.') }} đ</td>
                        <td class="border px-4 py-2 text-right text-green-700 font-medium">
                            {{ number_format($item->quantity * $item->import_price, 0, ',', '.') }} đ
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

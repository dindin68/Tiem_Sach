@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Chi tiết Phiếu Nhập {{ $import->id }}</h1>
    
    <p><strong>Ngày nhập:</strong> {{ $import->date->format('d/m/Y H:i') }}</p>
    <p><strong>Nhà cung cấp:</strong> {{ $import->provider }}</p>
    <p><strong>Nhân viên nhập:</strong> {{ $import->admin->name ?? 'Không rõ' }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($import->total_cost, 0, ',', '.') }} đ</p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Danh sách sách đã nhập:</h2>
    <table class="w-full border text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Tên sách</th>
                <th class="p-2 border">Số lượng</th>
                <th class="p-2 border">Giá nhập</th>
                <th class="p-2 border">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($import->items as $item)
                <tr>
                    <td class="p-2 border">{{ $item->book->title ?? 'Không tìm thấy' }}</td>
                    <td class="p-2 border">{{ $item->quantity }}</td>
                    <td class="p-2 border">{{ number_format($item->import_price, 0, ',', '.') }} đ</td>
                    <td class="p-2 border text-right">{{ number_format($item->quantity * $item->import_price, 0, ',', '.') }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

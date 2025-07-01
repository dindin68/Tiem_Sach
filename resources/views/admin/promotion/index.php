@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">Quản lý khuyến mãi</h1>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('admin.promotions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">Thêm khuyến mãi</a>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Mã khuyến mãi</th>
                <th class="border p-2">Giảm giá (%)</th>
                <th class="border p-2">Ngày bắt đầu</th>
                <th class="border p-2">Ngày kết thúc</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promotions as $promotion)
            <tr>
                <td class="border p-2">{{ $promotion->code }}</td>
                <td class="border p-2">{{ $promotion->discount }}%</td>
                <td class="border p-2">{{ $promotion->start_date }}</td>
                <td class="border p-2">{{ $promotion->end_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $promotions->links() }}
</div>
@endsection
@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-blue-600">Dashboard Quản trị</h1>
    <p class="text-gray-700">Chào mừng bạn đến với khu vực quản trị!</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-bold">Quản lý sách</h2>
            <a href="{{ route('admin.books.index') }}" class="text-blue-500">Xem chi tiết</a>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-bold">Quản lý đơn hàng</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-blue-500">Xem chi tiết</a>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-bold">Quản lý khuyến mãi</h2>
            <a href="{{ route('admin.promotions.index') }}" class="text-blue-500">Xem chi tiết</a>
        </div>
    </div>
</div>
@endsection
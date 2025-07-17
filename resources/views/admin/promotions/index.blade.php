<!-- resources/views/admin/promotions/index.blade.php -->
@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-2">

    <div class="flex justify-between items-center bg-orange-50 border-l-4 border-green-800 rounded shadow mb-4">
        <h2 class="text-lg pl-2 font-semibold text-brown-800">Quản lý khuyến mãi</h2>

        <div class="flex items-center gap-2 mr-2">
            <a href="{{ route('admin.promotions.history') }}"
                class="flex items-center bg-brown-800 hover:bg-green-800 text-white px-2 py-2 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-2"viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path fill="#ffffff" d="M75 75L41 41C25.9 25.9 0 36.6 0 57.9L0 168c0 13.3 10.7 24 24 24l110.1 0c21.4 0 32.1-25.9 17-41l-30.8-30.8C155 85.5 203 64 256 64c106 0 192 86 192 192s-86 192-192 192c-40.8 0-78.6-12.7-109.7-34.4c-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6C151.2 495 201.7 512 256 512c141.4 0 256-114.6 256-256S397.4 0 256 0C185.3 0 121.3 28.7 75 75zm181 53c-13.3 0-24 10.7-24 24l0 104c0 6.4 2.5 12.5 7 17l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-65-65 0-94.1c0-13.3-10.7-24-24-24z"/>
                </svg>
            </a>

            <a href="{{ route('admin.books.create') }}"
                class="bg-green-800 hover:bg-green-700 text-white px-4 py-2 rounded my-2">
                Thêm khuyến mãi mới
            </a>
        </div>
    </div>


    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">Mã khuyến mãi</th>
                    <th class="border px-4 py-2">Giảm giá (%)</th>
                    <th class="border px-4 py-2">Ngày bắt đầu</th>
                    <th class="border px-4 py-2">Ngày kết thúc</th>
                    <th class="border px-4 py-2">Sách áp dụng</th>
                    <th class="border px-4 py-2">Trạng thái</th>
                    <th class="border px-4 py-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($promotions as $promotion)
                    
                    <tr class=" bg-gray-100">
                        <td class="border px-4 py-2">{{ $promotion->id }}</td>
                        <td class="border px-4 py-2">{{ $promotion->discount_percentage }}</td>
                        <td class="border px-4 py-2">{{ $promotion->start_date }}</td>
                        <td class="border px-4 py-2">{{ $promotion->end_date }}</td>
                        <td class="border px-4 py-2">
                            @forelse ($promotion->books as $book)
                                {{ $book->title }}<br>
                            @empty
                                Không có sách
                            @endforelse
                        </td>
                        <td class="border px-4 py-2">
                            <span class="{{ $promotion->isActive() ? 'text-green-600' : 'text-gray-500' }}">
                                {{ $promotion->isActive() ? 'Hoạt động' : 'Hết hiệu lực' }}
                            </span>
                        </td>                        
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.promotions.edit', $promotion) }}" class="text-blue-500 hover:underline mr-2">Sửa</a>
                            <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" class="inline-block" onsubmit="return confirm('Xóa khuyến mãi này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">Không có khuyến mãi nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $promotions->links() }}
    </div>
</div>
@endsection
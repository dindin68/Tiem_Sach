<!-- resources/views/admin/promotions/index.blade.php -->
@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-4">Quản lý khuyến mãi</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('admin.promotions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">
        Thêm khuyến mãi
    </a>

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
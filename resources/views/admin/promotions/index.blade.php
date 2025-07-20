@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4">
    <!-- Tiêu đề + Nút -->
    <div class="flex justify-between items-center bg-orange-50 border-l-4 border-green-800 rounded-lg shadow px-4 py-3">
        <h2 class="text-xl font-semibold text-green-900"> Quản lý Khuyến mãi</h2>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.promotions.history') }}"
               class="flex items-center bg-brown-800 hover:bg-green-800 text-white px-3 py-2 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Lịch sử
            </a>
            <a href="{{ route('admin.promotions.create') }}"
               class="bg-green-800 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                 Thêm khuyến mãi
            </a>
        </div>
    </div>

    <!-- Bảng danh sách -->
    <div class="overflow-x-auto mt-4 rounded-lg shadow border border-gray-200 overflow-hidden">
        <table class="min-w-full text-sm text-center">
            <thead class="bg-green-100 text-brown-800 uppercase">
                <tr>
                    <th class="border px-4 py-2">Mã KM</th>
                    <th class="border px-4 py-2">Giảm (%)</th>
                    <th class="border px-4 py-2">Bắt đầu</th>
                    <th class="border px-4 py-2">Kết thúc</th>
                    <th class="border px-4 py-2">Sách áp dụng</th>
                    <th class="border px-4 py-2">Trạng thái</th>
                    <th class="border px-4 py-2">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($promotions as $promotion)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 font-mono">{{ $promotion->id }}</td>
                        <td class="border px-4 py-2">{{ $promotion->discount_percentage }}%</td>
                        <td class="border px-4 py-2">{{ $promotion->start_date }}</td>
                        <td class="border px-4 py-2">{{ $promotion->end_date }}</td>
                        <td class="border px-4 py-2 text-left">
                            @forelse ($promotion->books as $book)
                                <div>- {{ $book->title }}</div>
                            @empty
                                <span class="italic text-gray-400">Không có sách</span>
                            @endforelse
                        </td>
                        <td class="border px-4 py-2">
                            <span class="{{ $promotion->isActive() ? 'text-green-600 font-medium' : 'text-gray-400 italic' }}">
                                {{ $promotion->isActive() ? 'Hoạt động' : 'Hết hiệu lực' }}
                            </span>
                        </td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('admin.promotions.edit', $promotion) }}" class="text-blue-600 hover:underline">Sửa</a>
                            <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Xóa khuyến mãi này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-500 italic">Không có khuyến mãi nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    @if ($promotions->hasPages())
        <div class="mt-6">
            {{ $promotions->links() }}
        </div>
    @endif
</div>
@endsection

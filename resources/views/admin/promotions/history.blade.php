@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4 text-brown-800">Lịch sử khuyến mãi: {{ $history->first()->book_title ?? 'Không có dữ liệu' }}</h2>

    <!-- Bộ lọc tìm kiếm -->
    <form method="GET" action="" class="mb-4 flex items-center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên sách..." 
            class="border border-gray-300 rounded px-3 py-2 mr-2 focus:outline-none focus:ring focus:border-blue-400">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tìm</button>
    </form>

    <!-- Bảng lịch sử -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded shadow">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-2 px-3 border">Mã KM</th>
                    <th class="py-2 px-3 border">% Giảm</th>
                    <th class="py-2 px-3 border">Bắt đầu</th>
                    <th class="py-2 px-3 border">Kết thúc</th>
                    <th class="py-2 px-3 border">Ghi nhận</th>
                    <th class="py-2 px-3 border">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($history as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-3 border text-center">{{ $item->promotion_id }}</td>
                        <td class="py-2 px-3 border text-center">{{ $item->discount_percentage }}%</td>
                        <td class="py-2 px-3 border text-center">{{ $item->start_date }}</td>
                        <td class="py-2 px-3 border text-center">{{ $item->end_date }}</td>
                        <td class="py-2 px-3 border text-center">{{ $item->created_at }}</td>
                        <td class="py-2 px-3 border text-center">
                            <form method="POST" action="{{ route('admin.promotions.history.delete', $item->history_id) }}"
                                  onsubmit="return confirm('Xoá dòng này?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Chưa có lịch sử</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

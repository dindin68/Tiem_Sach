@extends('admin.layouts.app')

@section('content')
    <div class="container px-4">
        <!-- Tiêu đề + Nút -->
        <div
            class="flex flex-col md:flex-row justify-between items-center bg-orange-50 border-l-4 border-green-700 rounded-lg shadow px-4 py-3 gap-4 md:gap-0">
            <!-- Tiêu đề -->
            <h2 class="text-xl font-semibold text-green-900">Quản lý Khuyến mãi</h2>

            <!-- Thanh công cụ bên phải -->
            <div class="flex flex-col sm:flex-row items-center gap-2">
                <!-- Form tìm kiếm -->
                <form action="{{ route('admin.promotions.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-64 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Tìm kiếm mã khuyến mãi...">
                    <button type="submit"
                        class="bg-green-700 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z" />
                        </svg>
                        Tìm
                    </button>
                </form>

                <!-- Lịch sử khuyến mãi -->
                <a href="{{ route('admin.promotions.history') }}"
                    class="bg-green-700 hover:bg-green-600 text-white px-3 py-2 rounded-lg flex items-center gap-1 text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M320 128C426 128 512 214 512 320C512 426 426 512 320 512C254.8 512 197.1 479.5 162.4 429.7C152.3 415.2 132.3 411.7 117.8 421.8C103.3 431.9 99.8 451.9 109.9 466.4C156.1 532.6 233 576 320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C234.3 64 158.5 106.1 112 170.7L112 144C112 126.3 97.7 112 80 112C62.3 112 48 126.3 48 144L48 256C48 273.7 62.3 288 80 288L104.6 288C105.1 288 105.6 288 106.1 288L192.1 288C209.8 288 224.1 273.7 224.1 256C224.1 238.3 209.8 224 192.1 224L153.8 224C186.9 166.6 249 128 320 128zM344 216C344 202.7 333.3 192 320 192C306.7 192 296 202.7 296 216L296 320C296 326.4 298.5 332.5 303 337L375 409C384.4 418.4 399.6 418.4 408.9 409C418.2 399.6 418.3 384.4 408.9 375.1L343.9 310.1L343.9 216z" />
                    </svg>
                    Lịch sử
                </a>

                <!-- Thêm khuyến mãi -->
                <a href="{{ route('admin.promotions.create') }}"
                    class="bg-green-700 hover:bg-green-600 text-white px-3 py-2 rounded-lg flex items-center gap-1 text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                    </svg>
                    Thêm mã
                </a>
            </div>
        </div>


        <!-- Bảng danh sách -->
        <div class="overflow-x-auto mt-4 rounded-lg shadow border border-gray-200 overflow-hidden">
            <table class="min-w-full text-sm text-center">
                <thead class="bg-gray-100 text-brown-800 uppercase">
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
                                <span
                                    class="{{ $promotion->isActive() ? 'text-green-600 font-medium' : 'text-gray-400 italic' }}">
                                    {{ $promotion->isActive() ? 'Hoạt động' : 'Hết hiệu lực' }}
                                </span>
                            </td>
                            <td class="border px-4 py-2 space-x-2">
                                <a href="{{ route('admin.promotions.edit', $promotion) }}"
                                    class="text-blue-600 hover:underline">Sửa</a>
                                <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Xóa khuyến mãi này?')">
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
                {{ $promotions->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
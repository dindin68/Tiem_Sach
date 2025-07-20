@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4">
    <!-- Tiêu đề -->
    <div class="flex justify-between items-center bg-orange-50 border-l-4 border-green-700 rounded-lg shadow px-4 py-3">
        <h2 class="text-xl font-semibold text-green-900"> Quản lý Sách</h2>
        <a href="{{ route('admin.books.create') }}"
           class="bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">
             Thêm Sách
        </a>
    </div>

    <!-- Form áp dụng khuyến mãi -->
    <form action="{{ route('admin.promotions.apply') }}" method="POST" class="mt-6 space-y-4">
        @csrf
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <label for="promotion_id" class="font-medium text-gray-700">Áp dụng khuyến mãi:</label>
                <select name="promotion_id" id="promotion_id"
                        class="border border-gray-300 px-3 py-2 rounded-md shadow-sm focus:ring focus:ring-green-300">
                    @foreach ($promotions as $promotion)
                        <option value="{{ $promotion->id }}">
                            {{ $promotion->id }} - Giảm {{ $promotion->discount_percentage }}%
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                        class="bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-md transition">
                    Áp dụng
                </button>
            </div>

            <!-- Tìm kiếm -->
            <div class="relative w-full sm:w-72">
                <input type="text" placeholder=" Tìm sách..."
                       class="w-full h-10 pr-10 pl-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Bảng sách -->
        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full border-collapse text-sm text-center">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="p-2 border">
                            <input type="checkbox" id="checkAll"> Tất cả
                        </th>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Ảnh</th>
                        <th class="p-2 border">Tên sách</th>
                        <th class="p-2 border">Tác giả</th>
                        <th class="p-2 border">Giá (VND)</th>
                        <th class="p-2 border">Kho</th>
                        <th class="p-2 border">Thể loại</th>
                        <th class="p-2 border">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr class="hover:bg-gray-50">
                            <td class="border p-2">
                                <input type="checkbox" name="book_ids[]" value="{{ $book->id }}" class="book-checkbox">
                            </td>
                            <td class="border p-2">{{ $book->id }}</td>
                            <td class="border p-2">
                                @if ($book->images->first())
                                    <img src="{{ Storage::url($book->images->first()->path) }}"
                                         class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 flex items-center justify-center text-xs text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </td>
                            <td class="border p-2">{{ $book->title }}</td>
                            <td class="border p-2">{{ $book->authors->pluck('name')->join(' & ') }}</td>
                            <td class="border p-2">
                                @if ($book->discounted_price && $book->discounted_price < $book->price)
                                    <div class="text-gray-500 line-through">{{ number_format($book->price) }}</div>
                                    <div class="text-red-600 font-semibold">{{ number_format($book->discounted_price) }}</div>
                                @else
                                    {{ number_format($book->price) }}
                                @endif
                            </td>
                            <td class="border p-2">{{ $book->stock }}</td>
                            <td class="border p-2">{{ $book->category?->name ?? 'Không có' }}</td>
                            <td class="border p-2">
                                <div class="flex justify-center gap-2">
                                    <!-- Sửa -->
                                    <a href="{{ route('admin.books.edit', $book) }}"
                                       onclick="return {{ $book->is_discounted ? 'confirm(\'Sách đang có khuyến mãi. Bạn vẫn muốn chỉnh sửa?\')' : 'true' }}"
                                       class="text-blue-500 hover:text-blue-700" title="Sửa">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512" class="w-5 h-5 fill-current">
                                            <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7z"/>
                                        </svg>
                                    </a>

                                    <!-- Xóa -->
                                    <button type="button"
                                            onclick="submitDelete('{{ route('admin.books.destroy', $book) }}')"
                                            class="text-red-500 hover:text-red-700" title="Xóa">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 448 512" class="w-5 h-5 fill-current">
                                            <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0L284.2 0c12.1 0 23.2 6.8 28.6 17.7L320 32l96 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 96C14.3 96 0 81.7 0 64S14.3 32 32 32l96 0 7.2-14.3zM32 128l384 0 0 320c0 35.3-28.7 64-64 64L96 512c-35.3 0-64-28.7-64-64l0-320zm96 64c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $books->links() }}
        </div>
    </form>

    <!-- Form xóa ẩn -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
    document.getElementById('checkAll').addEventListener('change', function () {
        document.querySelectorAll('.book-checkbox').forEach(cb => cb.checked = this.checked);
    });

    function submitDelete(url) {
        if (confirm('Bạn có chắc chắn muốn xóa sách này?')) {
            const form = document.getElementById('delete-form');
            form.action = url;
            form.submit();
        }
    }
</script>
@endsection

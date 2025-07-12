@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mt-4 bg-orange-50 border-l-4 border-green-800 rounded shadow">
        <h2 class="text-lg pl-2 font-semibold text-brown-800">Danh Sách Sách</h2>

        <a href="{{ route('admin.books.create') }}"
        class="bg-green-800 hover:bg-green-700 text-white px-4 py-2 m-2 rounded">
            Thêm Sách Mới
        </a>
    </div>


    <!-- Form chọn sách để áp dụng khuyến mãi -->
    <form action="{{ route('admin.promotions.apply') }}" method="POST">
        @csrf

        <div class="flex flex-row items-center mt-4 justify-between">
            <!-- Dropdown khuyến mãi -->
            <div>
                <label for="promotion_id" class="mr-2 font-medium whitespace-nowrap">Khuyến mãi:</label>

                <select name="promotion_id" id="promotion_id" class="border px-4 py-2 rounded min-w-[200px] pr-8">
                    @foreach ($promotions as $promotion)
                        <option value="{{ $promotion->id }}">
                            {{ $promotion->id }} - Giảm {{ $promotion->discount_percentage }}%
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                        class="bg-green-800 hover:bg-green-700 text-white px-4 py-2 m-2 rounded">
                    Áp dụng
                </button>
            </div>

            <!-- Tìm kiếm -->
            <div class="relative w-72">
                    <input type="text" placeholder="Tìm kiếm sách..."
                        class="w-full h-10 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

        </div>

        <!-- Bảng danh sách sách -->
        <table class="w-full mt-4 border-collapse text-center">

            <thead class="sticky top-0 bg-gray-100 text-brown-800">
                <tr >
                    <th class="min-w-[80px] border">
                        Tất cả
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th class="border">ID</th>
                    <th class="border">Hình ảnh</th>
                    <th class="border">Tên sách</th>
                    <th class="border">Tác giả</th>
                    <th class="border">Giá (VND)</th>
                    <th class="border">Còn</th>
                    <th class="border">Thể loại</th>
                    <th class="border">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($books as $book)
                <tr>
                    <td class="border p-2">
                        <input type="checkbox" name="book_ids[]" value="{{ $book->id }}" class="book-checkbox">
                    </td>
                    <td class="border p-2">{{ $book->id }}</td>
                    <td class="border p-2">
                        @if ($book->images->first())
                            <img src="{{ Storage::url($book->images->first()->path) }}" alt="{{ $book->title }}" class="w-16 h-16 object-cover">
                        @else
                            <div class="w-16 h-16 bg-gray-200 flex items-center justify-center">No Image</div>
                        @endif
                    </td>
                    <td class="border p-2">{{ $book->title }}</td>
                    <td class="border p-2">{{ $book->authors->pluck('name')->join(' & ') }}</td>
                    <td class="border p-2">{{ number_format($book->price) }}</td>
                    <td class="border p-2">{{ $book->stock }}</td>
                    <td class="border p-2">{{ $book->category?->name ?? 'Không có danh mục' }}</td>
                    <td class="border p-2 space-x-2 ">
                        <div class="flex flex-row justify-center ">
                                <!-- Sửa -->
                            <a href="{{ route('admin.books.edit', $book) }}" class="text-blue-500 hover:text-blue-700 h-auto">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"
                                    class="w-5 h-5 fill-current mx-1">
                                    <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/>
                                </svg>
                            </a>

                            <!-- Xóa -->
                            <button type="button"
                                    onclick="submitDelete('{{ route('admin.books.destroy', $book) }}')"
                                    class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 448 512"
                                    class="w-5 h-5 fill-current mx-1">
                                    <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0L284.2 0c12.1 0 23.2 6.8 28.6 17.7L320 32l96 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 96C14.3 96 0 81.7 0 64S14.3 32 32 32l96 0 7.2-14.3zM32 128l384 0 0 320c0 35.3-28.7 64-64 64L96 512c-35.3 0-64-28.7-64-64l0-320zm96 64c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16z"/>
                                </svg>
                            </button>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <!-- Pagination -->
    {{ $books->links() }}

    <!-- Form xóa ẩn -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
    // Chọn tất cả
    document.getElementById('checkAll').addEventListener('change', function () {
        const checked = this.checked;
        document.querySelectorAll('.book-checkbox').forEach(cb => cb.checked = checked);
    });

    // Gửi form xóa
    function submitDelete(url) {
        if (confirm('Xóa sách này?')) {
            const form = document.getElementById('delete-form');
            form.action = url;
            form.submit();
        }
    }
</script>
@endsection

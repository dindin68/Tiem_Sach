@extends('admin.layouts.app')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center bg-orange-50 border-l-4 border-green-700 rounded-lg shadow px-4 py-4 gap-4">
        <!-- Tiêu đề -->
        <h2 class="text-xl font-semibold text-green-900"> Quản lý Thể loại</h2>

        <!-- Tìm kiếm + Thêm mới -->
        <div class="flex flex-col sm:flex-row items-center gap-2">
            <!-- Form tìm kiếm -->
            <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-64 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                       placeholder=" Tìm kiếm thể loại...">
                <button type="submit"
                        class="bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                    <svg class="w-5 h-5" fill="white" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 640 512">
                        <path
                            d="M416 208C416 278.7 358.7 336 288 336C217.3 336 160 278.7 160 208C160 137.3 217.3 80 288 80C358.7 80 416 137.3 416 208zM640 480c0 17.7-14.3 32-32 32H32C14.3 512 0 497.7 0 480C0 372.3 86 288 192 288h192c106 0 192 84.3 192 192z"/>
                    </svg>
                </button>
            </form>

            <!-- Nút thêm -->
            <a href="{{ route('admin.categories.create') }}"
               class="bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                 Thêm Thể loại
            </a>
        </div>
    </div>

    <!-- Bảng danh sách -->
    <div class="overflow-x-auto mt-5 rounded-lg shadow border border-gray-200">
        <table class="min-w-full border text-sm text-center">
            <thead class="bg-gray-100 text-green-900 uppercase">
                <tr>
                    <th class="px-4 py-3 border">Mã</th>
                    <th class="px-4 py-3 border">Tên Thể loại</th>
                    <th class="px-4 py-3 border">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 bg-white">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $category->id }}</td>
                        <td class="px-4 py-2 border font-medium">{{ $category->name }}</td>
                        <td class="px-4 py-2 border space-x-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                               class="text-blue-600 hover:underline"> Sửa</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa thể loại này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"> Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 text-gray-500 italic">Không có thể loại nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    @if ($categories->hasPages())
        <div class="mt-6">
            {{ $categories->appends(request()->only('search'))->links() }}
        </div>
    @endif

@endsection

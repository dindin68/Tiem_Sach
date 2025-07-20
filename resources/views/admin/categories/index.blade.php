@extends('admin.layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Tiêu đề + Nút thêm -->
        <div
            class="flex flex-col md:flex-row justify-between items-center bg-orange-50 border-l-4 border-green-700 rounded-lg shadow px-4 py-3">
            <h2 class="text-xl font-semibold text-green-900"> Quản lý Thể loại</h2>
            <a href="{{ route('admin.categories.create') }}"
                class="mt-2 md:mt-0 bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">
                Thêm Thể loại
            </a>
        </div>

        <!-- Tìm kiếm -->
        <div class="flex justify-end mt-4">
            <div class="relative w-full max-w-xs">
                <input type="text" placeholder="Tìm kiếm thể loại..." class="w-full h-10 pr-10 pl-3 border border-gray-300 rounded-lg shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Bảng danh sách -->
        <div class="overflow-x-auto mt-4 rounded-lg shadow">
            <table class="min-w-full border text-sm text-center rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-green-100 text-brown-800 uppercase">
                        <th class="px-4 py-2 border">Mã thể loại</th>
                        <th class="px-4 py-2 border">Tên danh mục</th>
                        <th class="px-4 py-2 border">Hành động</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $category->id }}</td>
                            <td class="border px-4 py-2">{{ $category->name }}</td>
                            <td class="border px-4 py-2 space-x-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="text-blue-600 hover:underline">Sửa</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thể loại này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Xóa</button>
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
    </div>
    <!-- Phân trang -->
    @if ($categories->hasPages())
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @endif
@endsection
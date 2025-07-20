@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <!-- Tiêu đề và nút thêm -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-orange-50 border-l-4 border-green-700 rounded-lg shadow px-4 py-3">
        <h1 class="text-xl font-semibold text-green-900"> Quản lý Tác giả</h1>
        <a href="{{ route('admin.authors.create') }}"
           class="mt-2 md:mt-0 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
             Thêm tác giả
        </a>
    </div>
    <!-- Tìm kiếm -->
    <div class="flex justify-end mt-4">
        <div class="relative w-full max-w-xs">
            <input
                type="text"
                placeholder="Tìm kiếm tác giả..."
                class="w-full h-10 pr-10 pl-3 border border-gray-300 rounded-lg shadow-sm
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
    <div class="overflow-x-auto mt-4 bg-white rounded-lg shadow">
        <table class="min-w-full border text-sm text-center">
            <thead class="bg-gray-100 text-gray-700 uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 border">ID</th>
                    <th class="px-4 py-3 border">Ảnh</th>
                    <th class="px-4 py-3 border">Tên tác giả</th>
                    <th class="px-4 py-3 border">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($authors as $author)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $author->id }}</td>
                        <td class="border px-4 py-2">
                            @if ($author->photo)
                                <img src="{{ asset('storage/' . $author->photo) }}" alt="Ảnh tác giả"
                                     class="w-12 h-12 object-cover rounded-full mx-auto shadow-sm border">
                            @else
                                <span class="text-gray-400 italic">Không có ảnh</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $author->name }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('admin.authors.edit', $author->id) }}"
                               class="text-blue-600 hover:underline">Sửa</a>
                            <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa tác giả này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-gray-500 italic">Chưa có tác giả nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

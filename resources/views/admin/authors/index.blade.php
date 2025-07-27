@extends('admin.layouts.app')

@section('content')
    <div class="container">

        <!-- Tiêu đề và nút thêm -->
        <div
            class="flex flex-col md:flex-row justify-between items-center bg-orange-50 border-l-4 border-green-700 rounded-lg shadow px-4 py-3 gap-4 md:gap-0">
            <h2 class="text-xl font-semibold text-green-900">Quản lý Tác giả</h2>

            <div class="flex items-center gap-2">
                <form action="{{ route('admin.authors.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-64 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 text-sm"
                        placeholder="Tìm kiếm tác giả...">
                    <button type="submit" class="bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                            <path fill="#ffffff"
                                d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z" />
                        </svg>
                    </button>
                </form>
                <a href="{{ route('admin.authors.create') }}"
                    class="bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition text-sm whitespace-nowrap">
                    Thêm Tác giả
                </a>
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
                                <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tác giả này?')">
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
        <div class="mt-4">
            {{ $authors->appends(request()->only('search'))->links() }}
        </div>
    </div>
@endsection
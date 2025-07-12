@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-600">Quản lý tác giả</h1>
        <a href="{{ route('admin.authors.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            + Thêm tác giả
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full table-auto border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Ảnh</th>
                <th class="p-2 border">Tên tác giả</th>
                <th class="p-2 border">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($authors as $index => $author)
            <tr class="hover:bg-gray-50">
                <td class="p-2 border text-center">{{ $author->id }}</td>
                <td class="p-2 border text-center">
                    @if ($author->photo)
                        <img src="{{ asset('storage/' . $author->photo) }}" class="w-12 h-12 rounded-full object-cover mx-auto">
                    @else
                        <span class="text-gray-400 italic">Không có ảnh</span>
                    @endif
                </td>
                <td class="p-2 border">{{ $author->name }}</td>
                <td class="p-2 border text-center space-x-2">
                    <a href="{{ route('admin.authors.edit', $author->id) }}" class="text-blue-600 hover:underline">Sửa</a>
                    <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="inline" onsubmit="return confirm('Xóa tác giả này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">Chưa có tác giả nào</td>
            </tr>
            @endforelse
        </tbody>
    </table>

@endsection

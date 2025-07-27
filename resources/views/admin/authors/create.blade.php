@extends('admin.layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold text-green-800 mb-6">Thêm tác giả mới</h1>

    <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Tên tác giả -->
        <div>
            <label for="name" class="block text-gray-700 font-medium mb-1">Tên tác giả <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                   required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ảnh đại diện -->
        <div>
            <label for="photo" class="block text-gray-700 font-medium mb-1">Ảnh đại diện</label>
            <input type="file" name="photo" id="photo"
                   class="w-full px-3 py-2 border rounded file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-green-100 file:text-green-800 hover:file:bg-green-200">
            @error('photo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Thông tin thêm -->
        <div>
            <label for="infor" class="block text-gray-700 font-medium mb-1">Thông tin thêm</label>
            <textarea name="infor" id="infor" rows="5"
                      class="w-full px-3 py-2 border rounded resize-y focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('infor') }}</textarea>
            @error('infor')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nút hành động -->
        <div class="pt-2 flex items-center gap-4">
            <button type="submit"
                class="bg-green-800 hover:bg-green-700 text-white font-medium px-5 py-2 rounded shadow-sm transition">
                Lưu
            </button>
            <a href="{{ route('admin.authors.index') }}" class="text-gray-600 hover:text-gray-800 underline">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection

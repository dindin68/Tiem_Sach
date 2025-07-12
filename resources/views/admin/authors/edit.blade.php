@extends('admin.layouts.app')

@section('content')
<div class="max-w-md mx-auto p-4">
    <h1 class="text-xl font-bold text-blue-600 mb-4">Chỉnh sửa tác giả</h1>

    <form action="{{ route('admin.authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-medium">Tên tác giả</label>
            <input type="text" name="name" id="name" value="{{ old('name', $author->name) }}"
                   class="w-full p-2 border rounded" required>
            @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="photo" class="block font-medium">Ảnh hiện tại</label>
            @if ($author->photo)
                <img src="{{ asset('storage/' . $author->photo) }}" class="w-24 h-24 rounded-full object-cover mb-2">
            @else
                <p class="text-gray-400 italic">Không có ảnh</p>
            @endif

            <label for="photo" class="block font-medium mt-2">Cập nhật ảnh (tùy chọn)</label>
            <input type="file" name="photo" id="photo" class="w-full p-2 border rounded">
            @error('photo') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="infor" class="block font-medium">Thông tin thêm</label>
            <textarea name="infor" id="infor" rows="5"
                    class="w-full p-4 text-lg border rounded resize-y">
                    {{ old('infor',$author->infor) }}
            </textarea>
            @error('infor') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Cập nhật
        </button>
        <a href="{{ route('admin.authors.index') }}" class="ml-2 text-gray-600 hover:underline">Quay lại</a>
    </form>
</div>
@endsection

@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Thêm danh mục</h1>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="flex justify-center ">
            <div class="mb-4 w-full mx-2 ">
                <label class="block text-gray-700">Mã Thể Loại</label>
                <input type="text" name="id" class="border rounded px-4 py-2 w-full" required>
            </div>
            <div class="mb-4 w-full mx-2 ">
                <label class="block text-gray-700">Tên Thể Loại</label>
                <input type="text" name="name" class="border rounded px-4 py-2 w-full" required>
            </div>
        </div>
        <button class="bg-green-800 text-white px-4 py-2 rounded">Lưu</button>
    </form>
</div>
@endsection

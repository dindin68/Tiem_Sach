@extends('admin.layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Chi tiết sách</h2>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-semibold">{{ $book->title }}</h3>
            <p><strong>Tác giả:</strong> {{ $book->authors->pluck('name')->join(', ') ?: 'Chưa có' }}</p>
            <p><strong>Thể loại:</strong> {{ $book->category->name ?? 'Không có' }}</p>
            <p><strong>Giá bán:</strong> {{ number_format($book->price, 0, ',', '.') }} đ</p>

            <p><strong>Số lượng nhập vào:</strong> {{ $book->imported }}</p>
            <p><strong>Số lượng đã bán:</strong> {{ $book->sold }}</p>
            <p><strong>Số lượng tồn kho:</strong> {{ $book->stock }}</p>

            <p><strong>Mô tả:</strong> {{ $book->description }}</p>
        </div>


        <h3 class="text-lg font-semibold mt-6">Lịch sử nhập hàng</h3>
        <table class="mt-2 w-full border text-sm text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Ngày nhập</th>
                    <th class="px-4 py-2 border">Số lượng</th>
                    <th class="px-4 py-2 border">Giá nhập</th>
                    <th class="px-4 py-2 border">Nhà cung cấp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($importHistory as $item)
                    <tr>
                        <td class="border px-4 py-2">{{ $item->import->date->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2">{{ $item->quantity }}</td>
                        <td class="border px-4 py-2">{{ number_format($item->import_price, 0, ',', '.') }} đ</td>
                        <td class="border px-4 py-2">{{ $item->import->provider }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="italic text-gray-500 py-2">Chưa có dữ liệu nhập hàng.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('admin.books.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">← Quay lại danh
            sách</a>
    </div>
@endsection
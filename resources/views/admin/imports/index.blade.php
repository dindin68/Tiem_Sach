@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <!-- Tiêu đề + Nút tạo đơn nhập -->
    <div class="flex justify-between items-center bg-orange-50 border-l-4 border-green-700 rounded-lg shadow px-4 py-3">
        <h2 class="text-xl font-semibold text-green-900"> Quản lý Đơn Nhập Hàng</h2>
        <a href="{{ route('admin.imports.create') }}"
           class="bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">
             Tạo đơn nhập
        </a>
    </div>

    <!-- Bảng danh sách -->
    <div class="overflow-x-auto mt-4 rounded-lg shadow border border-gray-200 overflow-hidden">
        <table class="min-w-full text-sm text-center">
            <thead class="bg-green-100 text-brown-800 uppercase">
                <tr>
                    <th class="px-4 py-2 border">Mã đơn</th>
                    <th class="px-4 py-2 border">Ngày nhập</th>
                    <th class="px-4 py-2 border">Nhà cung cấp</th>
                    <th class="px-4 py-2 border">Tổng tiền</th>
                    <th class="px-4 py-2 border">Người nhập</th>
                    <th class="px-4 py-2 border">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($imports as $import)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 font-mono">{{ $import->id }}</td>
                        <td class="border px-4 py-2">{{ $import->date->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">{{ $import->provider }}</td>
                        <td class="border px-4 py-2 text-green-700 font-semibold">
                            {{ number_format($import->total_cost, 0, ',', '.') }} đ
                        </td>
                        <td class="border px-4 py-2">{{ $import->admin->name ?? 'Không rõ' }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('admin.imports.show', $import->id) }}"
                               class="text-blue-600 hover:underline">Chi tiết</a>
                            <form action="{{ route('admin.imports.destroy', $import->id) }}"
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa đơn nhập này?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500 italic">Chưa có đơn nhập nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    @if ($imports->hasPages())
        <div class="mt-6">
            {{ $imports->links() }}
        </div>
    @endif
</div>
@endsection

@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <!-- Tiêu đề + Nút tạo đơn -->
    <div class="flex justify-between items-center bg-brown-50 border-l-4 border-gray-700 rounded-lg shadow px-4 py-3">
        <h2 class="text-xl font-semibold text-gray-800"> Quản lý Đơn Nhập Hàng</h2>
        <a href="{{ route('admin.imports.create') }}"
           class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
             Tạo đơn nhập
        </a>
    </div>

    <!-- Form lọc -->
    <form method="GET" class="bg-white rounded-lg shadow p-4 mt-4 space-y-4 md:space-y-0 md:flex md:space-x-4 items-end">
        <div>
            <label for="import_id" class="block text-sm font-medium text-gray-700">Tìm theo Mã đơn</label>
            <input type="text" id="import_id" name="import_id" value="{{ request('import_id') }}"
                   class="border-gray-300 rounded-md shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="date_from" class="block text-sm font-medium text-gray-700">Từ ngày</label>
            <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                   class="border-gray-300 rounded-md shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="date_to" class="block text-sm font-medium text-gray-700">Đến ngày</label>
            <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                   class="border-gray-300 rounded-md shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white font-semibold px-4 py-2 rounded-md">
                 Lọc
            </button>
        </div>
    </form>

    <!-- Bảng danh sách -->
    <div class="overflow-x-auto mt-6 rounded-lg shadow border border-gray-300">
        <table class="min-w-full text-sm text-center">
            <thead class="bg-gray-200 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-2 border">Mã đơn</th>
                    <th class="px-4 py-2 border">Ngày nhập</th>
                    <th class="px-4 py-2 border">Nhà cung cấp</th>
                    <th class="px-4 py-2 border">Tổng tiền</th>
                    <th class="px-4 py-2 border">Người nhập</th>
                    <th class="px-4 py-2 border">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($imports as $import)
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2 font-mono">{{ $import->id }}</td>
                        <td class="border px-4 py-2">{{ $import->date->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">{{ $import->provider }}</td>
                        <td class="border px-4 py-2 text-green-700 font-semibold">
                            {{ number_format($import->total_cost, 0, ',', '.') }} đ
                        </td>
                        <td class="border px-4 py-2">{{ $import->admin->name ?? 'Admin' }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('admin.imports.show', $import->id) }}"
                               class="text-indigo-600 hover:underline">Chi tiết</a>
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
                        <td colspan="6" class="py-4 text-center text-gray-500 italic">Không tìm thấy đơn nhập nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    @if ($imports->hasPages())
        <div class="mt-6">
            {{ $imports->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

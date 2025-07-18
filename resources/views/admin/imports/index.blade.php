@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto max-w-6xl p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold text-blue-600 mb-6">Danh sách đơn nhập hàng</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2 border">Mã đơn</th>
                    <th class="px-4 py-2 border">Ngày nhập</th>
                    <th class="px-4 py-2 border">Nhà cung cấp</th>
                    <th class="px-4 py-2 border">Tổng tiền</th>
                    <th class="px-4 py-2 border">Người nhập</th>
                    <th class="px-4 py-2 border text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($imports as $import)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 border font-mono">{{ $import->id }}</td>
                        <td class="px-4 py-2 border">{{ $import->date->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 border">{{ $import->provider }}</td>
                        <td class="px-4 py-2 border text-green-700 font-semibold">
                            {{ number_format($import->total_cost, 0, ',', '.') }} đ
                        </td>
                        <td class="px-4 py-2 border">{{ $import->admin->name ?? 'Không rõ' }}</td>
                        <td class="px-4 py-2 border text-center">
                            <a href="{{ route('imports.show', $import->id) }}" class="text-blue-600 hover:underline">Chi tiết</a>
                        </td>
                    </tr>
                @endforeach

                @if($imports->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Chưa có đơn nhập nào</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $imports->links() }} {{-- phân trang nếu dùng paginate() --}}
    </div>
</div>
@endsection

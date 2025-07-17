@extends('admin.layouts.app')

@section('content')
    <h2 class="text-xl font-semibold mb-4">Lịch sử khuyến mãi</h2>

    <form method="GET" action="{{ route('admin.promotions.history') }}" class="mb-4 flex items-center gap-3 flex-wrap">
        <select name="book_id" class="border px-3 py-2 rounded">
            <option value="">-- Chọn sách --</option>
            @foreach($books as $book)
                <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                    {{ $book->title }}
                </option>
            @endforeach
        </select>

        <input type="date" name="start_date" value="{{ request('start_date') }}" class="border px-3 py-2 rounded">
        <input type="date" name="end_date" value="{{ request('end_date') }}" class="border px-3 py-2 rounded">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Lọc</button>

        <a href="{{ route('admin.promotions.history.export') }}" class="bg-green-600 text-white px-4 py-2 rounded">Xuất Excel</a>
    </form>

    <table class="table-auto w-full text-left border-collapse border">
        <thead>
            <tr>
                <th class="border px-3 py-2">Sách</th>
                <th class="border px-3 py-2">% Giảm</th>
                <th class="border px-3 py-2">Từ</th>
                <th class="border px-3 py-2">Đến</th>
                <th class="border px-3 py-2">Ghi nhận</th>
                <th class="border px-3 py-2">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($history as $item)
                <tr>
                    <td class="border px-3 py-2">{{ $item->book_title }}</td>
                    <td class="border px-3 py-2">{{ $item->discount_percentage }}%</td>
                    <td class="border px-3 py-2">{{ $item->start_date }}</td>
                    <td class="border px-3 py-2">{{ $item->end_date }}</td>
                    <td class="border px-3 py-2">{{ $item->created_at }}</td>
                    <td class="border px-3 py-2">
                        <form method="POST" action="{{ route('admin.promotions.history.delete', $item->history_id) }}" onsubmit="return confirm('Xoá dòng này?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Xoá</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-3">Không có dữ liệu phù hợp</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $history->appends(request()->query())->links() }}
    </div>
@endsection

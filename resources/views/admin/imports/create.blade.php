@extends('admin.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Tạo phiếu nhập</h2>

    <form action="{{ route('admin.imports.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label>Ngày nhập:</label>
                <input type="datetime-local" name="date" value="{{ now()->format('Y-m-d\TH:i') }}" class="w-full border px-2 py-1 rounded">
            </div>
            <div>
                <label>Nhà cung cấp:</label>
                <input type="text" name="provider" class="w-full border px-2 py-1 rounded">
            </div>
        </div>

        <table class="w-full border text-center text-sm" id="product-table">
            <thead class="bg-gray-100">
                <tr>
                    <th>#</th>
                    <th>Sách</th>
                    <th>Số lượng</th>
                    <th>Giá nhập</th>
                    <th>Thành tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="product-rows"></tbody>
        </table>

        <button type="button" id="add-row" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded">+ Thêm sản phẩm</button>

        <div class="text-right mt-4 font-bold text-lg">
            Tổng tiền: <span id="total-amount">0</span> đ
        </div>

        <div class="mt-6 text-right">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded">Lưu phiếu nhập</button>
        </div>

        <template id="book-row-template">
    <tr>
        <td>__INDEX__</td>
        <td>
            <select name="books[__INDEX__][book_id]" class="book-select border px-1 py-1 rounded w-full">
                @foreach ($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="books[__INDEX__][quantity]" value="1" class="qty border px-1 py-1 w-20 text-right"></td>
        <td><input type="number" name="books[__INDEX__][price]" value="0" class="price border px-1 py-1 w-28 text-right" step="0.01"></td>
        <td><span class="subtotal">0</span> đ</td>
        <td><button type="button" onclick="this.closest('tr').remove(); updateTotal()"></button></td>
    </tr>
</template>

    </form>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('js/admin/imports/import-form.js') }}"></script>
@endpush


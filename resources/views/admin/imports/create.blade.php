@extends('admin.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6"> Tạo Phiếu Nhập Hàng</h2>

    <form action="{{ route('admin.imports.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block font-medium text-gray-700 mb-1"> Ngày nhập:</label>
                <input type="datetime-local" name="date" value="{{ now()->format('Y-m-d\TH:i') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1"> Nhà cung cấp:</label>
                <input type="text" name="provider"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border text-sm text-center rounded-lg overflow-hidden" id="product-table">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-2 py-2 border"></th>
                        <th class="px-2 py-2 border"> Sách</th>
                        <th class="px-2 py-2 border"> Số lượng</th>
                        <th class="px-2 py-2 border"> Giá nhập</th>
                        <th class="px-2 py-2 border"> Thành tiền</th>
                        <th class="px-2 py-2 border"></th>
                    </tr>
                </thead>
                <tbody id="product-rows"></tbody>
            </table>
        </div>

        <button type="button" id="add-row"
                class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow inline-flex items-center">
             Thêm sản phẩm
        </button>

        <div class="text-right mt-6 text-lg font-semibold text-indigo-700">
            Tổng tiền: <span id="total-amount" class="ml-1">0</span> đ
        </div>

        <div class="mt-6 text-right">
            <button type="submit"
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded font-semibold shadow">
                 Lưu phiếu nhập
            </button>
        </div>

        <!-- Template hàng sản phẩm -->
        <template id="book-row-template">
            <tr>
                <td class="border px-2 py-1">__INDEX__</td>
                <td class="border px-2 py-1">
                    <select name="books[__INDEX__][book_id]"
                            class="book-select border-gray-300 rounded shadow-sm w-full">
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">{{ $book->title }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="border px-2 py-1">
                    <input type="number" name="books[__INDEX__][quantity]" value="1"
                           class="qty text-right border-gray-300 rounded w-20 py-1">
                </td>
                <td class="border px-2 py-1">
                    <input type="number" name="books[__INDEX__][price]" value="0"
                           class="price text-right border-gray-300 rounded w-28 py-1" step="0.01">
                </td>
                <td class="border px-2 py-1 text-right text-green-700 font-medium">
                    <span class="subtotal">0</span> đ
                </td>
                <td class="border px-2 py-1">
                    <button type="button"
                            class="text-red-600 hover:text-red-800 font-bold"
                            onclick="this.closest('tr').remove(); updateTotal();">X
                    </button>
                </td>
            </tr>
        </template>
    </form>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('js/admin/imports/import-form.js') }}"></script>
@endpush

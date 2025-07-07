<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Book;

use App\Models\PromotionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    // Hiển thị danh sách khuyến mãi
    public function index()
    {
        $promotions = Promotion::paginate(8);
        return view('admin.promotions.index', compact('promotions'));
    }

    // Form tạo khuyến mãi
    public function create()
    {
        return view('admin.promotions.create');
    }

    // Lưu khuyến mãi mới
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:50|unique:promotions',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Promotion::create([
            'id' => $request->id,
            'discount_percentage' => $request->discount_percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.promotions.index')->with('success', 'Thêm khuyến mãi thành công.');
    }

    // Áp dụng khuyến mãi cho nhiều sách + lưu lịch sử
    public function applyToBooks(Request $request)
    {
        $request->validate([
            'promotion_id' => 'required|exists:promotions,id',
            'book_ids' => 'required|array',
            'book_ids.*' => 'exists:books,id',
        ]);

        foreach ($request->book_ids as $bookId) {
            DB::table('promotion_detail')->updateOrInsert(
                ['book_id' => $bookId],
                ['promotion_id' => $request->promotion_id]
            );
        }

        return redirect()->route('admin.books.index')->with('success', 'Khuyến mãi đã được áp dụng.');
    }

    public function edit(Promotion $promotion)
    {
        $books = Book::all(); // Lấy tất cả sách để chọn
        $selectedBooks = $promotion->books->pluck('id')->toArray(); // Lấy sách đã được chọn
        return view('admin.promotions.edit', compact('promotion', 'books', 'selectedBooks'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code,' . $promotion->id,
            'name' => 'required|string|max:100',
            'discount' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'books' => 'nullable|array',
            'books.*' => 'exists:books,id',
        ]);

        $promotion->update($request->only(['code', 'name', 'discount', 'start_date', 'end_date']));
        $promotion->books()->sync($request->books ? array_fill_keys($request->books, ['discount' => $request->discount]) : []);

        return redirect()->route('admin.promotions.index')->with('success', 'Cập nhật khuyến mãi thành công.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->books()->detach(); // Xóa các liên kết với sách
        $promotion->delete(); // Xóa bản ghi khuyến mãi

        return redirect()->route('admin.promotions.index')->with('success', 'Xóa khuyến mãi thành công.');
    }
    // Xoá 1 dòng lịch sử khuyến mãi
    public function deleteHistory($id)
    {
        PromotionHistory::where('id', $id)->delete();
        return back()->with('success', 'Xoá lịch sử khuyến mãi thành công!');
    }

    // Hiển thị lịch sử khuyến mãi của một sách
    public function showPromotionHistory()
    {
        $history = DB::table('promotion_history AS ph')
            ->join('books AS b', 'ph.book_id', '=', 'b.id')
            ->leftJoin('promotions AS p', 'ph.promotion_id', '=', 'p.id')
            ->select(
                'ph.id AS history_id',
                'b.id AS book_id',
                'b.title AS book_title',
                'p.id AS promotion_id',
                'ph.discount_percentage',
                'ph.start_date',
                'ph.end_date'
            )
            ->orderBy('ph.created_at', 'desc')
            ->get();

        return view('admin.promotions.history', compact('history'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Book;
use App\Models\PromotionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PromotionController extends Controller
{
    // Hiển thị danh sách khuyến mãi
    public function index(Request $request)
    {
        $query = Promotion::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('discount_percentage', 'like', "%{$search}%");
            });
        }

        $promotions = $query->orderByDesc('created_at')->paginate(10);

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

        Promotion::create($request->only('id', 'discount_percentage', 'start_date', 'end_date'));

        return redirect()->route('admin.promotions.index')->with('success', 'Thêm khuyến mãi thành công.');
    }

    // Áp dụng khuyến mãi cho nhiều sách
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

    // Sửa khuyến mãi
    public function edit(Promotion $promotion)
    {
        $books = Book::all();
        $selectedBooks = $promotion->books->pluck('id')->toArray();
        return view('admin.promotions.edit', compact('promotion', 'books', 'selectedBooks'));
    }

    // Cập nhật khuyến mãi
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'discount_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
                function ($attribute, $value, $fail) use ($promotion) {
                    $exists = Promotion::where('discount_percentage', $value)
                        ->where('id', '!=', $promotion->id)
                        ->exists();
                    if ($exists) {
                        $fail('Phần trăm giảm giá đã được dùng.');
                    }
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'books' => 'nullable|array',
            'books.*' => 'exists:books,id',
        ]);

        $promotion->update($request->only('discount_percentage', 'start_date', 'end_date'));
        $promotion->books()->sync($request->books ?? []);

        return redirect()->route('admin.promotions.index')->with('success', 'Cập nhật khuyến mãi thành công.');
    }

    // Xóa khuyến mãi
    public function destroy(Promotion $promotion)
    {
        $promotion->books()->detach();
        $promotion->delete();

        return redirect()->route('admin.promotions.index')->with('success', 'Xóa khuyến mãi thành công.');
    }

    // Xóa 1 dòng lịch sử
    public function deleteHistory($id)
    {
        PromotionHistory::where('id', $id)->delete();
        return back()->with('success', 'Xóa lịch sử khuyến mãi thành công!');
    }

    // Lịch sử khuyến mãi
    public function showPromotionHistory(Request $request)
    {
        $query = DB::table('promotion_history AS ph')
            ->join('books AS b', 'ph.book_id', '=', 'b.id')
            ->leftJoin('promotions AS p', 'ph.promotion_id', '=', 'p.id')
            ->select(
                'ph.id AS history_id',
                'b.id AS book_id',
                'b.title AS book_title',
                'ph.promotion_id',
                'ph.discount_percentage',
                'ph.start_date',
                'ph.end_date',
                'ph.created_at'
            );

        if ($request->filled('book_id')) {
            $query->where('ph.book_id', $request->book_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('ph.start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('ph.end_date', '<=', $request->end_date);
        }
        if ($request->filled('promotion_id')) {
            $query->where('ph.promotion_id', 'LIKE', '%' . $request->promotion_id . '%');
        }


        $history = $query->orderByDesc('ph.created_at')->paginate(10);
        $books = Book::select('id', 'title')->get();

        return view('admin.promotions.history', compact('history', 'books'));
    }

    // Xử lý khuyến mãi hết hạn
    public function removeExpiredPromotions()
    {
        $now = Carbon::now();

        $expiredPromotions = Promotion::where('end_date', '<', $now)->get();

        foreach ($expiredPromotions as $promotion) {
            foreach ($promotion->books as $book) {
                PromotionHistory::create([
                    'book_id' => $book->id,
                    'promotion_id' => $promotion->id,
                    'discount_percentage' => $promotion->discount_percentage,
                    'start_date' => $promotion->start_date,
                    'end_date' => $promotion->end_date,
                    'created_at' => now(),
                ]);
            }

            $promotion->books()->detach();
            $promotion->delete();
        }

        return response()->json(['message' => 'Khuyến mãi hết hạn đã được xoá và cập nhật vào lịch sử.']);
    }

    public function deletePromotionHistory($id)
    {
        DB::table('promotion_history')->where('id', $id)->delete();
        return redirect()->route('admin.promotions.history')->with('success', 'Xoá lịch sử khuyến mãi thành công!');
    }
}

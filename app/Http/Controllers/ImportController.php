<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\ImportItem;
use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        $imports = Import::with('admin')->orderByDesc('date')->paginate(10);
        return view('admin.imports.index', compact('imports'));
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function create()
    {
        $books = Book::all();
        return view('admin.imports.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'provider' => 'required|string|max:100',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
            'books.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $importId = 'IMP' . now()->format('YmdHis');

            // Gộp các dòng trùng book_id
            $items = collect($request->books)
                ->groupBy('book_id')
                ->map(function ($group, $bookId) {
                    $book = Book::find($bookId);
                    return [
                        'book_id' => $group[0]['book_id'],
                        'book_title' => $book->title,
                        'quantity' => $group->sum('quantity'),
                        'import_price' => $group->last()['price'], // Lấy giá cuối cùng
                    ];
                })->values()->all();

            // Tính tổng tiền
            $total = collect($items)->sum(fn($item) => $item['quantity'] * $item['import_price']);

            // Tạo phiếu nhập
            $import = Import::create([
                'id' => $importId,
                'date' => $request->date,
                'provider' => $request->provider,
                'total_cost' => $total,
                'admin_id' => auth()->id(), // lấy id từ guard admin nếu có
            ]);

            // Tạo dòng chi tiết phiếu nhập
            $import->items()->createMany($items);

            // Cập nhật số lượng sách trong kho
            foreach ($items as $item) {
                $book = Book::find($item['book_id']);
                $book->imported += $item['quantity'];
                $book->stock = $book->imported - $book->sold;
                $book->save();
            }

        });

        return redirect()->route('admin.imports.create')->with('success', 'Phiếu nhập đã được lưu.');
    }

    public function show($id)
    {
        $import = Import::with(['items.book', 'admin'])->findOrFail($id);
        return view('admin.imports.show', compact('import'));
    }

    public function destroy($id)
    {
        $import = Import::with('items')->findOrFail($id);

        DB::transaction(function () use ($import) {
            // Trừ lại stock sách đã nhập
            foreach ($import->items as $item) {
                Book::where('id', $item->book_id)->decrement('stock', $item->quantity);
            }

            // Xóa các dòng chi tiết
            $import->items()->delete();

            // Xóa phiếu nhập
            $import->delete();
        });

        return redirect()->route('admin.imports.index')->with('success', 'Phiếu nhập đã được xóa.');
    }




}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cart = Cart::with('items.book.images')->where('customer_id', $user->id)->first();

        $items = collect();

        if ($cart) {
            $items = $cart->items->map(function ($item) {
                $book = $item->book;
                $imagePath = optional($book->images->first())->path;
                $item->image_url = $imagePath
                    ? Storage::url($imagePath)
                    : asset('images/default-book.png');

                return $item;
            });
        }

        return view('customer.cart', compact('items'));
    }

    public function add(Request $request, Book $book)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm vào giỏ hàng.');
        }

        // 1. Lấy cart đang hoạt động của user (pending), hoặc tạo mới
        $cart = Cart::firstOrCreate(
            ['customer_id' => $user->id],
            ['created_at' => now()]
        );

        // 2. Kiểm tra item đã có chưa
        $item = CartItem::where('cart_id', $cart->id)
            ->where('book_id', $book->id)
            ->first();

        $quantity = max(1, (int) $request->input('quantity', 1));
        $price = $book->is_discounted ? $book->discounted_price : $book->price;

        if ($item) {
            // Cập nhật số lượng và thành tiền
            $item->quantity += $quantity;
            $item->amount = $item->unit_price * $item->quantity;
            $item->save();
        } else {
            // Thêm mới
            CartItem::create([
                'cart_id' => $cart->id,
                'book_id' => $book->id,
                'quantity' => $quantity,
                'unit_price' => $price,
                'amount' => $quantity * $price,
                'notice' => $request->input('notice') ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function updateQuantity(Request $request, $book_id)
    {
        $user = Auth::user();
        $cart = Cart::where('customer_id', $user->id)->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Không có giỏ hàng.']);
        }

        $item = CartItem::where('cart_id', $cart->id)
            ->where('book_id', $book_id)
            ->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Sách không có trong giỏ hàng.']);
        }

        $quantity = max(1, (int) $request->input('quantity', 1));
        $item->quantity = $quantity;
        $item->amount = $item->unit_price * $quantity;
        $item->save();

        $total = $cart->items->sum('amount');

        return response()->json([
            'success' => true,
            'sub_total' => number_format($item->amount) . '₫',
            'total' => number_format($total) . '₫',
        ]);
    }

    public function destroy(CartItem $cartItem)
    {
        $user = Auth::user();

        // Kiểm tra người dùng có sở hữu cartItem này không
        if ($cartItem->cart->customer_id !== $user->id) {
            abort(403, 'Không có quyền xóa mục này.');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }




}

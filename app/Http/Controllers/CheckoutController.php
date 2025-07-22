<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Book;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CheckoutController extends Controller
{

    public function index()
    {
        // Tìm giỏ hàng của khách hàng hiện tại
        $cart = Cart::where('customer_id', Auth::id())->first();

        // Nếu không có giỏ hàng thì tạo mảng rỗng
        $items = $cart ? $cart->items : collect(); // dùng `collect()` để đảm bảo không bị null
        $total = $items->sum(fn($i) => $i->amount);

        return view('customer.checkout', compact('items', 'total'));
    }

    public function buyNow(Request $request)
{
    $book = Book::findOrFail($request->input('book_id'));
    $quantity = max((int) $request->input('quantity', 1), 1);

    // Lưu vào session để chuyển sang trang xác nhận thanh toán
    Session::put('buy_now', [
        'book_id' => $book->id,
        'title' => $book->title,
        'price' => $book->price,
        'quantity' => $quantity,
    ]);

    return redirect()->route('customer.checkout');
}


    public function redirectToCheckout(Request $request)
    {
        $book = Book::findOrFail($request->book_id);
        $quantity = max((int) $request->quantity, 1);

        // Gán dữ liệu mua ngay vào session
        Session::put('buy_now', [
            'book_id' => $book->id,
            'title' => $book->title,
            'price' => $book->price,
            'quantity' => $quantity,
        ]);

        return redirect()->route('checkout.show');
    }

    // B2: Trang hiển thị xác nhận đơn hàng
    public function show()
    {
        $sessionItem = Session::get('buy_now');

        if (!$sessionItem) {
            return redirect('/')->with('error', 'Không có sản phẩm để thanh toán.');
        }

        // Chuyển đổi sang cấu trúc giống giỏ hàng
        $book = Book::find($sessionItem['book_id']);

        $items = collect([
            (object) [
                'book' => $book,
                'quantity' => $sessionItem['quantity'],
                'unit_price' => $sessionItem['price'],
                'amount' => $sessionItem['price'] * $sessionItem['quantity'],
            ]
        ]);

        $total = $items->sum('amount');

        return view('customer.checkout', compact('items', 'total'));
    }

    // B3: Khi nhấn "Xác nhận thanh toán"
    public function process()
    {
        $data = Session::get('buy_now');

        if (!$data) {
            return redirect()->route('checkout.show')->with('error', 'Không có đơn hàng.');
        }

        $book = Book::findOrFail($data['book_id']);

        // Tạo đơn hàng
        $order = Order::create([
            'customer_id' => Auth::id(), // bạn cần middleware auth
            'total_amount' => $book->price * $data['quantity'],
            'status' => 'pending',
        ]);

        // Tạo chi tiết đơn hàng
        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => $data['quantity'],
            'unit_price' => $book->price,
            'amount' => $book->price * $data['quantity'],
        ]);

        // Xoá dữ liệu session
        Session::forget('buy_now');

        return redirect('/')->with('success', 'Thanh toán thành công. Đơn hàng đang được xử lý.');
    }


    public function checkout()
    {
        $cart = Cart::where('customer_id', Auth::id())->with('items.book')->first();
        $items = $cart?->items ?? collect();
        $total = $items->sum(fn($item) => $item->amount);

        return view('customer.checkout', compact('items', 'total'));
    }



}

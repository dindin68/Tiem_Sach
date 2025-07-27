<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Book;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CheckoutController extends Controller
{

    public function index()
    {
        // Tìm giỏ hàng của khách hàng hiện tại
        $cart = Cart::where('customer_id', Auth::id())->first();
        $paymentMethods = PaymentMethod::all();

        // Nếu không có giỏ hàng thì tạo mảng rỗng
        $items = $cart ? $cart->items : collect(); // dùng `collect()` để đảm bảo không bị null
        $total = $items->sum(fn($i) => $i->amount);

        

        return view('customer.checkout', compact('items', 'total','paymentMethods'));
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



    //Xác nhận thanh toán
    public function process(Request $request)
    {
        $customer = Auth::user();

        // Bước 1: Lưu địa chỉ giao hàng
        $address = Address::create([
            'customer_id' => $customer->id,
            'recipient_name' => $request->input('recipient_name'),
            'phone' => $request->input('phone'),
            'house_number' => $request->input('house_number'),
            'ward' => $request->input('ward'),
            'district' => $request->input('district'),
            'city' => $request->input('city'),
        ]);

        // Bước 2: Tính phí ship đơn giản
        $city = strtolower($address->city);
        $shippingFee = str_contains($city, 'cần thơ') ? 15000 : 30000;

        // Bước 3: Tính tổng tiền và xử lý đơn hàng
        $buyNow = Session::get('buy_now');
        $items = collect();
        $totalAmount = 0;

        if ($buyNow) {
            // Mua ngay
            $book = Book::findOrFail($buyNow['book_id']);

            $items->push((object) [
                'book_id' => $book->id,
                'quantity' => $buyNow['quantity'],
                'unit_price' => $book->price,
                'amount' => $book->price * $buyNow['quantity'],
            ]);

            $totalAmount = $items->sum('amount');
            Session::forget('buy_now');
        } else {
            // Từ giỏ hàng
            $cart = Cart::where('customer_id', $customer->id)->first();
            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('customer.checkout')->with('error', 'Giỏ hàng trống.');
            }

            $items = $cart->items;
            $totalAmount = $items->sum('amount');

            // Xóa giỏ hàng
            $cart->items()->delete();
            $cart->delete();
        }


        // Bước 4: Tạo đơn hàng
        $order = Order::create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'shipping_fee' => $shippingFee,
            'total_cost' => $totalAmount + $shippingFee,
            'status' => 'pending',
            'payment_method_id'=> $request->input('payment_method'),
            'date_order' => now(),

        ]);

        // Bước 5: Lưu chi tiết đơn hàng
        foreach ($items as $item) {
            // Tìm tên sách từ model Book (nếu có book_id)
            $bookTitle = null;

            if (isset($item->book)) {
                // Trường hợp từ giỏ hàng: có quan hệ book
                $bookTitle = $item->book->title;
            } elseif (isset($item->book_id)) {
                // Trường hợp mua ngay: truy vấn trực tiếp
                $bookTitle = optional(Book::find($item->book_id))->title;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item->book_id ?? null,
                'book_title' => $bookTitle ?? 'Không rõ',
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'amount' => $item->amount,
            ]);
        }


        return redirect('/')->with('success', 'Đơn hàng đã được đặt thành công!');
    }

    public function calculateShipping(Request $request)
    {
        $address = $request->input('address');

        if (!$address) {
            return response()->json(['error' => 'Vui lòng nhập địa chỉ.'], 400);
        }

        $fee = str_contains(strtolower($address), 'cần thơ') ? 15000 : 30000;

        // Lưu vào session
        Session::put('shipping_fee', $fee);

        return response()->json([
            'fee' => $fee,
            'formatted' => number_format($fee, 0, ',', '.') . ' đ'
        ]);
    }




    public function checkout(Request $request)
    {
        $customer = Auth::user();
        $sessionItem = Session::get('buy_now');

        if ($sessionItem) {
            // Mua ngay
            $book = Book::find($sessionItem['book_id']);

            $items = collect([
                (object) [
                    'book' => $book,
                    'quantity' => $sessionItem['quantity'],
                    'unit_price' => $sessionItem['price'],
                    'amount' => $sessionItem['price'] * $sessionItem['quantity'],
                ]
            ]);
        } else {
            // Giỏ hàng
            $cart = Cart::where('customer_id', $customer->id)->first();
            $items = $cart ? $cart->items : collect();
        }

        $total = $items->sum('amount');
        $customerAddress = $request->input('customer_address');

        // Tính phí ship
        if ($customerAddress) {
            if (str_contains(strtolower($customerAddress), 'cần thơ')) {
                $shippingFee = 15000;
            } else {
                $shippingFee = 30000;
            }
        } else {
            $shippingFee = null;
        }
        $paymentMethods = PaymentMethod::all();

        return view('customer.checkout', compact('items', 'total', 'shippingFee', 'customerAddress', 'customer','paymentMethods'));
    }




}

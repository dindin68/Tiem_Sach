<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'paymentMethod']);

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo ngày đặt hàng (theo khoảng)
        if ($request->filled('date_from')) {
            $query->whereDate('date_order', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date_order', '<=', $request->date_to);
        }

        $orders = $query->orderByDesc('date_order')->paginate(10);
        $statusColors = [
            'đang chuẩn bị' => 'bg-yellow-100 text-yellow-800',
            'đang vận chuyển' => 'bg-blue-100 text-blue-800',
            'hoàn thành' => 'bg-green-100 text-green-800',
            'hoàn trả' => 'bg-red-100 text-red-800',
        ];

        // Gắn màu tương ứng vào từng đơn hàng
        $orders->setCollection(
            $orders->getCollection()->transform(function ($order) use ($statusColors) {
                $statusKey = strtolower($order->status);
                $order->status_color = $statusColors[$statusKey] ?? 'bg-gray-100 text-gray-700';
                return $order;
            })
        );

        return view('admin.orders.index', compact('orders'));
    }


    // Chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with(['items.book', 'customer'])->findOrFail($id);
        $total = $order->items->sum('amount');
        return view('admin.orders.show', compact('total', 'order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng.');
    }

}
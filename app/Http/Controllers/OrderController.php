<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Account;
use App\Models\Customer;
use App\Models\ProductVariant;

class OrderController extends Controller
{
    public function checkout()
    {
        // Hiển thị trang thanh toán
        return view('checkout');
    }

    public function placeOrder(Request $request)
    {
        // Xử lý và lưu đơn hàng vào cơ sở dữ liệu
        $order = new Order();
        $order->name_order = $request->input('name');
        $order->phone_order = $request->input('phone');
        $order->address_order = $request->input('address');
        $order->total_order = $request->input('total');
        $order->note = $request->input('note');
        $order->save();

        // Lưu thông tin thanh toán nếu có
        $payment = new Payment();
        $payment->Name_payment = $request->input('payment_method');
        $payment->Id_order = $order->Id_order;
        $payment->save();

        // Xóa giỏ hàng sau khi đã đặt hàng thành công
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Đơn hàng đã được đặt thành công!');
    }

    public function showSearchForm()
    {
        return view('order_search');
    }
    public function search(Request $request)
    {
        // Lấy thông tin từ form tìm kiếm
        $emailOrPhone = $request->input('email_or_phone');
        $orderCode = $request->input('order_code');

        if (!$emailOrPhone || !$orderCode) {
            return redirect()->route('order.search.view')->with('error', 'Vui lòng nhập đầy đủ thông tin');
        }

        // Tìm tài khoản từ email hoặc số điện thoại
        $account = Customer::where('email_customer', $emailOrPhone)
            ->orWhere('phone_customer', $emailOrPhone)
            ->first();

        // Kiểm tra xem tài khoản có tồn tại không
        if ($account) {
            // Tìm đơn hàng từ id của tài khoản và mã đơn hàng
            $order = Order::where('id_customer', $account->id)
                ->where('code_order', $orderCode)
                ->first();

            if ($order) {
                // Lấy thông tin chi tiết đơn hàng
                $orderDetails = $order->orderDetails;
                return view('orderdetail', compact('order', 'orderDetails'));
            } else {
                // Không tìm thấy đơn hàng
                return view('order_not_found');
            }
        } else {
            // Không tìm thấy tài khoản
            return view('account_not_found');
        }
    }

    public function orderDetail($orderId)
    {
        $order = Order::findOrFail($orderId);
        $orderDetails = $order->orderDetails;

        return view('orderdetail', compact('order', 'orderDetails'));
    }

    public function cancelOrder($orderId)
{
    $order = Order::find($orderId);

    if ($order && $order->status_order == 1) {
        $order->status_order = 0;
        $order->save();
        if ($order->status_order == 0){
            foreach ($order->orderDetails as $orderDetail) {
                // Tìm sản phẩm và kích thước tương ứng để tăng số lượng
                $productSize = ProductVariant::where('product_id', $orderDetail->productid)
                    ->where('size_id', $orderDetail->sizeid)
                    ->where('color_id', $orderDetail->colorid)
                    ->first();

                if ($productSize) {
                    // Tăng số lượng sản phẩm và kích thước tương ứng
                    $productSize->quantity += $orderDetail->quantity;
                    $productSize->save();
                }
            }
        }
        return redirect()->back()->with('success', 'Đã huỷ đơn hàng thành công')->with('activeTab', 'orders');
    } else {
        return redirect()->back()->with('error', 'Không thể huỷ đơn hàng');
    }
}
}

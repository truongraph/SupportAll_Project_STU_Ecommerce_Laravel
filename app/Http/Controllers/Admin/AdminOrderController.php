<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('paymentmethod');

        // Lọc theo tên, mã, số điện thoại, email
        $nameCodeEmailPhone = $request->input('namecodeemailphone_filter');
        if ($nameCodeEmailPhone) {
            $query->where(function ($q) use ($nameCodeEmailPhone) {
                $q->where('name_order', 'like', '%' . $nameCodeEmailPhone . '%')
                    ->orWhere('code_order', 'like', '%' . $nameCodeEmailPhone . '%')
                    ->orWhere('email_order', 'like', '%' . $nameCodeEmailPhone . '%')
                    ->orWhere('phone_order', 'like', '%' . $nameCodeEmailPhone . '%');
            });
        }

        $paymentFilter = $request->input('payment_filter');
        if ($paymentFilter) {
            $query->whereHas('paymentmethod', function ($q) use ($paymentFilter) {
                $q->where('id', $paymentFilter);
            });
        }

        $statusFilter = $request->input('status_filter');
        if ($statusFilter !== null) {
            $query->where('status_order', $statusFilter);
        }

        $startDate = $request->input('start_date_filter');
        $endDate = $request->input('end_date_filter');

        if ($startDate && $endDate) {
            $query->whereBetween('date_order', [
                Carbon::createFromFormat('d/m/Y H:i', $startDate)->format('Y-m-d H:i:s'),
                Carbon::createFromFormat('d/m/Y H:i', $endDate)->format('Y-m-d H:i:s')
            ]);
        } elseif ($startDate) {
            $query->where('date_order', '>=', Carbon::createFromFormat('d/m/Y H:i', $startDate)->format('Y-m-d H:i:s'));
        } elseif ($endDate) {
            $query->where('date_order', '<=', Carbon::createFromFormat('d/m/Y H:i', $endDate)->format('Y-m-d H:i:s'));
        }

        $paymentMethods = Payment::pluck('name_payment', 'id');

        $orders = $query->get();

        return view('admin.orders.index', compact('orders', 'paymentMethods'));
    }

    public function delete($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
        if($order->status_order == 5){
            // Xóa các chi tiết đơn hàng liên quan
        $order->orderDetails()->delete();

        // Xóa đơn hàng
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xoá thành công.');
        }
        // Kiểm tra nếu đơn hàng chưa được hủy
        if ($order->status_order !== 0) {
            return redirect()->back()->with('error', 'Không thể xóa đơn hàng đã được xác nhận hoặc đang giao.');
        }

        // Xóa các chi tiết đơn hàng liên quan
        $order->orderDetails()->delete();

        // Xóa đơn hàng
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xoá thành công.');
    }

    public function updateStatus($id, $status)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }

        $order->status_order = $status;
        $order->save();

        if ($status == 5 || $status == 0 ){
            foreach ($order->orderDetails as $orderDetail) {
                // Tìm sản phẩm và kích thước tương ứng để tăng số lượng
                $productSize = ProductVariant::where('product_id', $orderDetail->productid)
                    ->where('size_id', $orderDetail->sizeid)
                    ->where('color_id', $orderDetail->colorid) // Tìm theo màu sắc
                    ->first();
                if ($productSize) {
                    // Tăng số lượng sản phẩm và kích thước tương ứng
                    $productSize->quantity += $orderDetail->quantity;
                    $productSize->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công.');
    }
    public function view($id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
        $orderDetails = $order->orderDetails;
        return view('admin.orders.view', compact('order', 'orderDetails'));
    }

    public function printInvoice($id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
        $orderDetails = $order->orderDetails;

        // Trả về view hoặc PDF để in hoá đơn
        return view('admin.orders.invoice', compact('order', 'orderDetails'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Discount;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Models\Customer;
use App\Models\Account;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    //===================================================
    //===================================================
    public function index()
    {
        $cart = session()->get('cart', []);


        if (!empty($cart)) {
            foreach ($cart as $cartKey => $item) {
                list($productid, $sizeid, $colorid) = explode('_', $cartKey);


                $productVariant = ProductVariant::where('product_id', $productid)
                    ->where('size_id', $sizeid)
                    ->where('color_id', $colorid)
                    ->first();


                if (!$productVariant || $item['quantity'] > $productVariant->quantity) {
                    return redirect()->route('cart.index')
                        ->with('error', 'Số lượng sản phẩm của bạn đã vượt số lượng tồn kho. Vui lòng kiểm tra lại giỏ hàng của bạn.')
                        ->withInput();
                }
                if (!empty($error)) {

                    return redirect()->route('cart.index')
                        ->with('error', $error);
                }
            }
        }


        $total = 0;
        foreach ($cart as $item) {
            if ($item['sellprice'] > 0) {
                $total += $item['sellprice'] * $item['quantity'];
            } else {
                $total += $item['price'] * $item['quantity'];
            }
        }

        $paymentmethods = Payment::all();
        $customerInfo = null;

        if (session()->has('account_id')) {
            $customerId = session('account_id');
            $customerInfo = Customer::where('id_account', $customerId)->first();
        }

        return view('cart.checkout', compact('cart', 'total', 'paymentmethods', 'customerInfo'));
    }
    //===================================================
    //===================================================
    public function applyDiscount(Request $request)
    {
        $discountCode = $request->input('discount_code');
        $discount = Discount::where('code', $discountCode)->first();

        if ($discount && $discount->expiration_date >= now()) {
            // Kiểm tra số lượt còn lại của mã
            $limitNumber = $discount->limit_number ?? PHP_INT_MAX;
            $timesUsed = $discount->number_used ?? 0;

            if ($timesUsed >= $limitNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá đã hết lượt sử dụng',
                ]);
            }

            $cart = $request->session()->get('cart', []);
            $totalPrice = 0;

            // Tính toán tổng giá trị sản phẩm trong giỏ hàng
            foreach ($cart as $item) {
                if ($item['sellprice'] > 0) {
                    $totalPrice += $item['sellprice'] * $item['quantity'];
                } else {
                    $totalPrice += $item['price'] * $item['quantity'];
                }
            }


            // Kiểm tra thanh toán tối thiểu
            $paymentLimit = $discount->payment_limit ?? 0;
            if ($totalPrice < $paymentLimit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tổng số tiền không đủ để áp dụng mã này',
                ]);
            }


            // Lưu tổng tiền trước khi áp dụng mã giảm giá vào session
            $request->session()->put('original_total', $totalPrice);

            // Áp dụng mã giảm giá thành công
            $totalPrice -= $discount->discount;


            return response()->json([
                'success' => true,
                'message' => 'Áp dụng mã giảm giá thành công',
                'totalPrice' => $totalPrice,
                'discountName' => $discount->code, // Thêm tên mã giảm giá vào JSON response
                'discountAmount' => $discount->discount, // Thêm số tiền đã giảm vào JSON response
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm không hợp lệ hoặc đã hết hạn',
            ]);
        }
    }
    //===================================================
    //===================================================
    //============Xóa mã giảm===========================
    public function removeDiscount(Request $request)
    {
        // Lấy tổng tiền trước khi áp dụng mã giảm giá
        $originalTotal = $request->session()->get('original_total', 0);
        // Kiểm tra có mã giảm giá được áp dụng hay không
        $hasDiscountApplied = false;
        // Xóa mã giảm giá khỏi session
        $request->session()->forget('discount_code');
        return response()->json([
            'success' => true,
            'message' => 'Gỡ mã giảm giá thành công',
            'originalTotal' => $originalTotal,
            'hasDiscountApplied' => $hasDiscountApplied, // Thêm trạng thái có mã giảm giá được áp dụng vào response
        ]);
    }


    public function process(Request $request)
    {
        // Lấy thông tin người mua
        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $address = $request->input('address');
        $note = $request->input('note');
        $paymentmethod = $request->input('payment_method');
        $totalPrice = $request->input('total_price');
        $dateOrder = Carbon::now('Asia/Ho_Chi_Minh');
        $cart = json_decode($request->input('cart'), true);
        $date = now()->format('dmy'); // ddmmyy
        $time = $dateOrder->format('Hi'); // Lấy giờ và phút hiện tại theo định dạng Hi
        $random = mt_rand(1, 9); // Sinh số ngẫu nhiên từ 10 đến 99
        $orderCode = "OD{$date}{$time}{$random}";
        $discountCode = $request->input('discount_code');
        $discount = Discount::where('code', $discountCode)->first();
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        foreach ($cart as $cartKey => $item) {
            list($productid, $sizeid, $colorid) = explode('_', $cartKey);

            // Kiểm tra số lượng của size và color trong ProductVariant
            $productVariant = ProductVariant::where('product_id', $productid)
                ->where('size_id', $sizeid)
                ->where('color_id', $colorid)
                ->first();

            if (!$productVariant || $item['quantity'] > $productVariant->quantity) {
                return redirect()->route('checkout.index')->with('error', 'Số lượng sản phẩm của bạn đã vượt số lượng tồn kho. Vui lòng kiểm tra lại giỏ hàng của bạn.')->withInput();
            }
        }
        if (empty($name) || empty($phone) || empty($address)) {
            return redirect()->route('checkout.index')->with('error', 'Vui lòng điền đầy đủ thông tin trước khi hoàn tất đặt hàng.')->withInput();
        }
        if(strlen($phone) != 10){
            return redirect()->route('checkout.index')->with('error', 'Số điện thoại phải là số có 10 chữ số.')->withInput();
        }
        // Kiểm tra email tồn tại
        $existingCustomer = Customer::where('email_customer', $email)->first();
        //Nếu chưa tồn tại
        if (!$existingCustomer) {
            $customer = new Customer();
            $customer->name_customer = $name;
            $customer->email_customer = $email;
            $customer->phone_customer = $phone;
            $customer->address_customer = $address;
            $customer->id_account = 1;
            $customer->save();
            // Tạo tài khoản mới dựa trên email của Customer
            $temporaryPassword = Str::random(10);
            $account = Account::create([
                'name_account' => explode('@', $customer->email_customer)[0],
                'email_account' => $customer->email_customer,
                'password_account' => md5($temporaryPassword),
                'status_account' => 1,
            ]);
            $customer->id_account = $account->id;
            $customer->save();
            //Tạo discount cho tài khoản mới
            $discountRandom = Str::random(3);
            $accountName = explode('@', $customer->email_customer)[0];
            $discountCodedata = 'WELCOME_' . strtoupper($accountName).$discountRandom;
            $expirationDatedata = Carbon::now()->addDays(30);
            $discountdata = new Discount();
            $discountdata->code = $discountCodedata;
            $discountdata->limit_number = 1;
            $discountdata->discount = min(50000, PHP_INT_MAX);
            $discountdata->expiration_date = $expirationDatedata;
            $discountdata->payment_limit = min(20000, PHP_INT_MAX);
            $discountdata->save();
            // Gửi email thông tin tài khoản, mã giảm giá và ngày hết hạn
            Mail::send('emails.account-information', ['account' => $account, 'password' => $temporaryPassword, 'discountCode' => $discountCodedata, 'expirationDate' => $expirationDatedata], function ($message) use ($customer) {
                $message->to($customer->email_customer)
                    ->subject('Thông tin tài khoản của bạn');
            });
        } else {
            if ($existingCustomer->account && $existingCustomer->account->status_account === 0) {
                return redirect()->route('checkout.index')->with('error', 'Email này đã bị ngừng hoạt động trong hệ thống. Vui lòng liên hệ quản trị viên.')->withInput();
            }
            $customer = $existingCustomer;
        }
        //Nếu đã tồn tại
        $customerId = $customer->id;
        $order = new Order();
        $order->name_order = $name;
        $codeOrder = $orderCode;
        $order->code_order = $codeOrder;
        $order->date_order = $dateOrder;
        $order->email_order = $email;
        $order->phone_order = $phone;
        $order->address_order = $address;
        $order->total_order = min($totalPrice, PHP_INT_MAX);
        if ($discount) {
            $order->discount_code = $discount->id;
        }
        $order->note = $note;
        $order->status_order = 1;
        $order->id_customer = $customerId;
        $order->id_payment = $paymentmethod;
        $order->save();
        // Lưu chi tiết vào orderdetail
        foreach ($cart as $cartKey => $item) {
            list($productid) = explode('_', $cartKey);
            $orderDetail = new OrderDetail();
            $orderDetail->orderid = $order->id;
            $orderDetail->productid = $productid;
            $orderDetail->colorid = $item['colorid'];
            $orderDetail->sizeid = $item['sizeid'];
            $orderDetail->quantity = $item['quantity'];
            $orderDetail->totalprice = isset($item['sellprice']) && $item['sellprice'] > 0 ? min($item['quantity'] * $item['sellprice'], PHP_INT_MAX) : min($item['quantity'] * $item['price'], PHP_INT_MAX);
            $orderDetail->save();
            // Cập nhật số lượng đã bán của sản phẩm
            $product = Product::find($productid);
            if ($product) {
                $product->number_buy += $item['quantity'];
                $product->save();
            }
        }
        if ($discount) {
            // Cập nhật số lượt sử dụng mã giảm giá
            $discount->number_used += 1;
            $discount->save();
        }
        // Cập nhật lại số lượng của ProductVariant sau khi xác nhận đơn hàng
        $productVariant->quantity -= $item['quantity'];
        $productVariant->save();

        $orderDetails = OrderDetail::with('product.sizes', 'product.colors')->where('orderid', $order->id)->get();
        // Xóa giỏ hàng sau khi đã thanh toán
        session()->forget('cart');
        // Gửi email xác nhận đơn hàng cho khách hàng
        Mail::to($order->email_order)->send(new OrderConfirmation($order, $orderDetails));
        // Trong hàm process của CheckoutController
        session(['orderId' => $order->id]);
        return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công');
    }

    //===================================================
    //===================================================
    public function success()
    {
        // Lấy thông tin đơn hàng
        $orderId = session('orderId');
        // Chỉnh sửa phần lưu session orderId sau khi đặt hàng
        $order = Order::with('customer')->find($orderId);
        $dateOrder = Carbon::createFromFormat('Y-m-d H:i:s', $order->date_order)->format('d/m/Y H:i:s');
        // Lấy thông tin chi tiết đơn hàng
        $orderDetails = OrderDetail::with('product')->where('orderid', $orderId)->get();
        $formattedDate = Carbon::parse($order->date_order)->format('d/m/Y H:i:s');

        return view('cart.success', compact('order', 'orderDetails', 'formattedDate'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\DiscountNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class AccountController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }
    public function loginSubmit(Request $request)
    {

        $login = $request->input('email');
        $password = md5($request->input('password'));

        $account = Account::where(function ($query) use ($login) {
            $query->where('email_account', $login)
                ->orWhere('name_account', $login);
        })->where('password_account', $password)->first();

        if(empty($login) || empty($password)){
            return response()->json(['error' => false, 'message' => 'Vui lòng điền đầy đủ thông tin đăng nhập!!']);
        }

        if ($account) {
            if ($account->status_account == 0) {
                return response()->json(['success' => false, 'message' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.']);
            }

            session(['account_id' => $account->id]);
            return response()->json(['success' => true, 'message' => 'Đăng nhập thành công']);
        } else {
            // Kiểm tra tài khoản không tồn tại trong hệ thống
            $checkAccount = Account::where('email_account', $login)
                            ->orWhere('name_account', $login)
                            ->first();

            if (!$checkAccount) {
                return response()->json(['success' => false, 'message' => 'Tài khoản không tồn tại trong hệ thống. Vui lòng đăng ký tài khoản mới.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Thông tin tài khoản hoặc mật khẩu không đúng']);
            }
        }
    }


    public function myAccount()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (session()->has('account_id')) {
            // Lấy thông tin tài khoản từ session
            $accountId = session('account_id');
            $account = Account::find($accountId);
            $customer = Customer::where('id_account', $accountId)->first();
            // Nếu tài khoản tồn tại, chuyển hướng tới trang myaccount và truyền thông tin tài khoản vào view
            if ($account) {
                $customer = $account->customer;
                $orders = $customer->orders;
                session(['activeTab' => 'dashboard']);
                return view('myaccount', compact('account', 'customer', 'orders'));
            }
        }

        // Nếu chưa đăng nhập hoặc không tìm thấy thông tin tài khoản, chuyển hướng về trang đăng nhập
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để truy cập trang này');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('account_id');
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công');
    }

    public function showChangePasswordForm()
    {
        return view('change_password');
    }
    public function changePassword(Request $request)
    {
        $accountId = session('account_id');
        $account = Account::findOrFail($accountId);

        $currentPassword = md5($request->input('current_password'));
        $newPassword = md5($request->input('new_password'));
        $confirmPassword = md5( $request->input('confirm_password'));

        if ($account->password_account !== $currentPassword) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không chính xác');
        }
        if ($newPassword === $currentPassword) {
            return redirect()->back()->with('error', 'Mật khẩu mới không được trùng với mật khẩu cũ.');
        }
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Mật khẩu mới và xác nhận mật khẩu không khớp.');
        }


        // Update password and save to the database
        $account->password_account = md5($newPassword);
        $account->save();
        $request->session()->forget('account_id');
        return redirect()->route('login')->with('success', 'Đã thay đổi mật khẩu thành công và đã đăng xuất.');
    }

    public function showRegisterForm()
    {
        return view('register');
    }
    public function register(Request $request)
    {

        // Lấy thông tin từ form đăng ký
        $username = $request->input('username');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = md5($request->input('password'));
        $repassword = md5($request->input('repassword'));
        $phone = $request->input('phone');

        /// Kiểm tra trống thông tin
        if (empty($username) || empty($name) || empty($email) || empty($password) || empty($repassword) || empty($phone)) {
            return redirect()->route('register')->with('error', 'Vui lòng điền đầy đủ thông tin bắt buộc có ( * ) đỏ.')->withInput();
        }

        /// Kiểm tra số điện thoại
        if (strlen($phone) !== 10) {
            return redirect()->route('register')->with('error', 'Số điện thoại phải có 10 chữ số.')->withInput();
        }

        /// Kiểm tra
        $existingUsernameAccount = Account::where('name_account', $username)->first();
        if ($existingUsernameAccount) {
            return redirect()->route('register')->with('error', 'Tên tài khoản đã tồn tại.')->withInput();
        }
        if ($repassword !== $password) {
            return redirect()->route('register')->with('error', 'Mật khẩu không khớp với nhau hãy kiểm tra')->withInput();
        }
        $existingAccount = Account::where('email_account', $email)->first();
        if ($existingAccount) {
            return redirect()->route('register')->with('error', 'Email đã tồn tại. Bạn có thể đăng nhập hoặc khôi phục mật khẩu nếu quên')->withInput();
        }
        $existingAccount = Customer::where('phone_customer', $phone)->first();
        if ($existingAccount) {
            return redirect()->route('register')->with('error', 'Số điện thoại đã tồn tại.')->withInput();
        }

        // Tạo tài khoản mới
        $account = new Account();
        $account->name_account = $username;
        $account->email_account = $email;
        $account->password_account = $password;
        $account->status_account = 1;
        $account->save();

        // Lấy ID của tài khoản vừa tạo
        $accountId = $account->id;

        // Tạo thông tin khách hàng mới và liên kết với tài khoản
        $customer = new Customer();
        $customer->id_account = $accountId;
        $customer->name_customer = $name;
        $customer->email_customer = $email;
        $customer->phone_customer = $phone;
        $customer->save();


        // Tạo mã giảm giá
        $accountName = $account->name_account;
        $discountCode = 'WELCOME_' . strtoupper($accountName);
        $expirationDate = Carbon::now()->addDays(30);

        $discount = new Discount();
        $discount->code = $discountCode;
        $discount->limit_number = 1;
        $discount->discount = min(50000, PHP_INT_MAX);
        $discount->payment_limit = min(20000, PHP_INT_MAX);
        $discount->expiration_date = $expirationDate;
        // Lưu thông tin mã giảm giá vào bảng Discount
        $discount->save();
        Mail::to($request->input('email'))->send(new DiscountNotification($discount, $account->name_account));
        // Redirect hoặc hiển thị thông báo thành công
        return redirect()->route('login')->with('success', 'Đăng ký tài khoản thành công.! Chúng tôi có tặng cho bạn 1 mã giảm qua email');
    }


    public function updateCustomerInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $name = $request->input('name');
        $phone  = $request->input('phone');
        $address = $request->input('address');

        if(empty($name) || empty($phone)){
            return redirect()->back()->with('error', 'Không được để trống thông tin');
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(strlen($phone) !== 10){
            return redirect()->back()->with('error', 'Số điện thoại phải là số có 10 chữ số');
        }

        $accountId = session('account_id');
        $customer = Customer::where('id_account', $accountId)->first();



        if ($customer) {
            $customer->name_customer = $request->input('name');
            $customer->phone_customer = $request->input('phone');
            $customer->address_customer = $request->input('address');

            // Kiểm tra xem số điện thoại mới có trùng với bất kỳ khách hàng nào khác không
            $existingCustomer = Customer::where('phone_customer', $phone)
            ->where('id', '!=', $customer->id)
            ->first();

            if ($existingCustomer) {
            return redirect()->back()->with('error', 'Số điện thoại này đã được sử dụng bởi khách hàng khác');
            }

            $customer->save();

            return redirect()->back()->with('success', 'Thông tin khách hàng đã được cập nhật thành công');
        }

        return redirect()->back()->with('error', 'Không tìm thấy thông tin khách hàng');
    }

}

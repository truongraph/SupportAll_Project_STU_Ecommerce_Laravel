<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Account;

class AdminCustomerController extends Controller
{
    public function index(Request $request)
{
    $query = Customer::query();

    // Lọc theo tên
    if ($request->has('name_filter')) {
        $query->where('name_customer', 'like', '%' . $request->input('name_filter') . '%');
    }

    // Lọc theo email
    if ($request->has('email_filter')) {
        $query->where('email_customer', 'like', '%' . $request->input('email_filter') . '%');
    }

    // Lọc theo số điện thoại
    if ($request->has('phone_filter')) {
        $query->where('phone_customer', 'like', '%' . $request->input('phone_filter') . '%');
    }

    $customers = $query->get();

    return view('admin.customers.index', compact('customers'));
}
    public function edit($id)
    {
        $customers = Customer::find($id);
        return view('admin.customers.edit', compact('customers'));
    }
    public function update(Request $request, $id)
    {
        // Tìm khách hàng theo ID
        $customer = Customer::find($id);

        // Nếu không tìm thấy khách hàng, hiển thị thông báo lỗi và chuyển hướng về trang trước
        if (!$customer) {
            return redirect()->back()->with('error', 'Không tìm thấy khách hàng');
        }

        // Validate dữ liệu từ form
        $validatedData = $request->validate([
            'name_customer' => 'required',
            'phone_customer' => 'required|digits:10|unique:customers,phone_customer,' . $id,
            'address_customer' => 'nullable',
            'email_customer' => 'required|email',
        ], [
            'name_customer.required' => 'Vui lòng không bỏ trống tên khách hàng',
            'phone_customer.required' => 'Vui lòng không bỏ trống thông tin số điện thoại',
            'phone_customer.unique' => 'Số điện thoại đã tồn tại cho một khách hàng khác',
            'phone_customer.digits' => 'Số điện thoại phải là số có 10 chữ số'
        ]);
        // Kiểm tra xem tên tài khoản và email có thay đổi không
        if ($validatedData['email_customer'] !== $customer->email_customer) {
            return redirect()->back()->with(['error' => 'Không được phép sửa email tài khoản']);
        }
        // Cập nhật thông tin khách hàng
        $customer->name_customer = $validatedData['name_customer'];
        $customer->phone_customer = $validatedData['phone_customer'];
        $customer->address_customer = $validatedData['address_customer'];
        // $customer->email_customer = $validatedData['email_customer'];

        // Lưu các thay đổi vào cơ sở dữ liệu
        $customer->save();

        // // Cập nhật thông tin email_account của account tương ứng
        // $account = $customer->account;
        // if ($account) {
        //     $account->email_account = $validatedData['email_customer'];
        //     $account->save();
        // }

        // Chuyển hướng về trang danh sách khách hàng với thông báo thành công
        return redirect()->route('admin.customers.index')->with('success', 'Đã cập nhật thông tin khách hàng');
    }
    public function delete($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->back()->with('error', 'Không tìm thấy khách hàng');
        }

        // Kiểm tra xem khách hàng có đơn hàng hay không
        if ($customer->orders()->exists()) {
            return redirect()->back()->with('error', 'Không thể xóa khách hàng vì khách hàng này có đơn hàng ');
        }

        // Xóa khách hàng
        $accountId = $customer->id_account;
        $customer->delete();

        // Xóa tài khoản nếu không còn khách hàng nào kết nối
        $relatedCustomers = Customer::where('id_account', $accountId)->count();
        if ($relatedCustomers === 0) {
            $account = Account::find($accountId);
            if ($account) {
                $account->delete();
            }
        }

        return redirect()->back()->with('success', 'Đã xoá khách hàng và tài khoản liên kết thành công');
    }
}

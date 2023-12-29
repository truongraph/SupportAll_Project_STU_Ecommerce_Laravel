<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminAccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('admin.accounts.index', compact('accounts'));
    }

    public function edit($id)
    {
        $account = Account::find($id);
        return view('admin.accounts.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name_account' => 'required',
            'email_account' => ['required', Rule::unique('accounts')->ignore($id)],
            'password_account' => 'nullable',
        ]);

        $account = Account::find($id);
        if (!$account) {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản');
        }

        // Kiểm tra nếu mật khẩu mới khác mật khẩu cũ
        if ($request->filled('password_account')) {
            $newPassword = $validatedData['password_account'];
            if (md5($newPassword) !== $account->password_account) {
                $account->password_account = md5($newPassword);
            } else {
                // Nếu mật khẩu mới trùng với mật khẩu cũ, không cho phép thay đổi
                return redirect()->back()->with('error', 'Mật khẩu mới không được trùng với mật khẩu cũ');
            }
        }

        $account->name_account = $validatedData['name_account'];
        $account->email_account = $validatedData['email_account'];
        $account->status_account = $request->has('status_account') ? 1 : 0;
        $account->save();

        session()->flash('success', 'Chỉnh sửa tài khoản thành công');
        return redirect()->route('admin.accounts.index');
    }

    public function block($id)
    {
        $account = Account::find($id);
        return view('admin.accounts.block', compact('account'));
    }

    public function blockacc(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name_account' => 'required',
            'email_account' => ['required', Rule::unique('accounts')->ignore($id)],
            'password_account' => 'nullable',
        ]);

        $account = Account::find($id);
        if (!$account) {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản');
        }

        $account->name_account = $validatedData['name_account'];
        $account->email_account = $validatedData['email_account'];

        if ($request->filled('password_account')) {
            $account->password_account = md5($validatedData['password_account']);
        }

        $account->status_account = $request->has('status_account') ? 1 : 0;
        $account->save();

        session()->flash('success', 'Chỉnh sửa tài khoản thành công');
        return redirect()->route('admin.accounts.index');
    }
    public function delete($id)
    {
        $account = Account::find($id);
        if (!$account) {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản');
        }

        $associatedCustomers = Customer::where('id_account', $id)->count();
        if ($associatedCustomers > 0) {
            return redirect()->back()->with('error', 'Không thể xoá tài khoản. Có khách hàng liên kết với tài khoản này.');
        }

        $account->delete();
        return redirect()->back()->with('success', 'Đã xoá tài khoản thành công');
    }
}

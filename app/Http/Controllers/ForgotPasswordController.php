<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    //==========================================
    //==========================================
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }
    //==========================================
    //==========================================
    public function sendResetLinkEmail(Request $request)
    {

        $email = $request->input('email');
        $account = Account::where('email_account', $email)->first();

        if(empty($email)){
            return redirect()->back()->with('error', 'Vui lòng nhập thông tin email của bạn !!.');
        }
        if (!$account) {
                return redirect()->back()->with('error', 'Email không tồn tại trong hệ thống.');
        }
        if ($account) {
            if ($account->status_account == 0) {
                return redirect()->back()->with('error', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.');
            }
            $token = Str::random(60);
            $account->update(['reset_password_token' => $token]);
            // Gửi email chứa link khôi phục mật khẩu tới email của người dùng
            $emailData = [
                'token' => $token,
                'email' => $account->email_account,
                'name_account' => $account->name_account,
            ];
            Mail::send('emails.forgot-password', $emailData, function ($message) use ($emailData) {
                $message->to($emailData['email'])
                    ->subject('Yêu cầu khôi phục mật khẩu');
            });
            return redirect()->back()->with('success', 'Chúng tôi đã gửi hướng dẫn khôi phục mật khẩu vào email của bạn.');
        }

    }
    //==========================================
    //==========================================
    public function showResetPasswordForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }
    //==========================================
    //==========================================
    public function resetPassword(Request $request)
    {

        $account = Account::where('reset_password_token', $request->input('token'))->first();

        if (!$account) {
            return redirect()->back()->with('error', 'Đường dẫn khôi phục mật khẩu không hợp lệ.');
        }

        $password = $request->input('password');
        $passwordConfirmation = $request->input('password_confirmation');

        //Kiểm tra mật khẩu trùng với mật khẩu hiện tại
        if(!$password || !$passwordConfirmation){
            return redirect()->back()->with('error', 'Vui lòng nhập đầy đủ thông tin.');
        }

        // Kiểm tra xem hai mật khẩu có khớp nhau không
        if ($password !== $passwordConfirmation) {
            return redirect()->back()->with('error', 'Mật khẩu nhập lại không khớp. Vui lòng nhập lại.');
        }

        $account->update([
            'password_account' => md5($password),
            'reset_password_token' => null,
        ]);

        return redirect()->route('login')->with('success', 'Mật khẩu đã được khôi phục thành công. Vui lòng đăng nhập.');
    }

}

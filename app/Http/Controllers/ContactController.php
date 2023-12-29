<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'title' => 'required|string',
            'content' => 'required|string',
        ],[
            'fullname.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'content.required' => 'Vui lòng nhập nội dung.',
            'phone.digits' => 'Số điện thoại phải là số có 10 chữ số.'
        ]);

        // Gửi email
        Mail::send('emails.contact', $validatedData, function ($message) use ($validatedData) {
            $message->from($validatedData['email'], $validatedData['fullname']);
            $message->to($validatedData['email'])->subject('Thông tin liên hệ từ hệ thống Torano Shop');
        });

        return redirect()->back()->with('success', 'Email đã được gửi thành công!');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Discount;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
       // Lấy ngày giờ hiện tại
    $now = Carbon::now();

    // Lấy danh sách các mã giảm giá còn hiệu lực và hạn sử dụng chưa qua
    $discounts = Discount::where('expiration_date', '>=', $now)
                    ->where('code', 'like', 'Dis%')
                    ->get();

    return view('discounts.index', compact('discounts'));
    }
}

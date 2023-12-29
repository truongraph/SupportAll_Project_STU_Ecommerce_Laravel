<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
class AdminDiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();
        return view('admin.discounts.index', compact('discounts'));
    }
     //============================================
    //============================================
    public function create()
    {
        return view('admin.discounts.create');
    }
    public function store(Request $request)
    {
        $filled = collect($request->all())->filter(); // Lọc bỏ các trường trống

        if ($filled->count() !== count($request->all())) {
            return redirect()->back()->with('error', 'Vui lòng nhập đầy đủ thông tin');
        }

        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:discounts,code',
            'discount' => 'required',
            'limit_number' => 'required',
            'expiration_date' => 'required',
            'payment_limit' => 'required',
        ], [
            'code.unique' => 'Mã giảm này đã tồn tại.',
            'expiration_date' => 'Ngày hết hạn không được để trống',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $expiration_date = Carbon::createFromFormat('d/m/Y H:i', $request->input('expiration_date'));

        $dateNow = Carbon::now();
        if ($expiration_date < $dateNow) {
            return redirect()->back()->with('error', 'Ngày và giờ hết hạn phải lớn hơn hoặc bằng ngày và giờ hiện tại.');
        }


        $discount = new Discount();
        $discount->code = $request->input('code');
        $discount->expiration_date = $expiration_date;
        $discount->discount = (float) str_replace(',', '', $request->input('discount'));
        $discount->limit_number = (int) str_replace(',', '', $request->input('limit_number'));
        $discount->payment_limit = (int) str_replace(',', '', $request->input('payment_limit'));


        $discount->save();

        return redirect()->route('admin.discounts.index')->with('success', 'Mã giảm giá đã được thêm thành công.');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('discounts')->ignore($id),
            ],
            'discount' => 'required',
            'limit_number' => 'required',
            'expiration_date' => 'required',
            'payment_limit' => 'required',
            'number_used' => 'required',
        ],  [
            'code.unique' => 'Mã giảm này đã tồn tại.',
        ]);

        $discount = Discount::findOrFail($id);

        // Kiểm tra xem mã giảm có tồn tại không
        if (!$discount) {
            return redirect()->back()->with('error', 'Không tìm thấy mã giảm.');
        }
        $expiration_date = Carbon::createFromFormat('d/m/Y H:i', $request->input('expiration_date'));

        $dateNow = Carbon::now();
        if ($expiration_date < $dateNow) {
            return redirect()->back()->with('error', 'Ngày và giờ hết hạn phải lớn hơn hoặc bằng ngày và giờ hiện tại.');
        }
        $discount->code = $request->input('code');
        $discount->expiration_date = $expiration_date;
        $discount->discount = (float) str_replace(',', '', $request->input('discount'));
        $discount->limit_number = (int) str_replace(',', '', $request->input('limit_number'));
        $discount->number_used = (int) str_replace(',', '', $request->input('number_used'));
        $discount->payment_limit = (int) str_replace(',', '', $request->input('payment_limit'));
        $discount->save();

        return redirect()->route('admin.discounts.index')->with('success', 'Mã giảm đã được cập nhật thành công.');
    }

    public function delete($id)
    {
        $discount = Discount::find($id);

        // Kiểm tra xem mã giảm giá có tồn tại trong bất kỳ đơn hàng nào không
        $ordersUsingDiscount = Order::where('discount_code', $id)->exists();

        if ($ordersUsingDiscount) {
            return redirect()->back()->with('error', 'Không thể xóa mã giảm giá vì nó được sử dụng trong các đơn hàng.');
        }

        $discount->delete();

        return redirect()->back()->with('success', 'Mã giảm giá đã được xóa thành công.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\ProductVariant;
use App\Models\OrderDetail;
class AdminColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.colors', compact('colors'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'desc_color' => 'required|unique:colors,desc_color'
        ], [
            'desc_color.unique' => 'Màu sắc này đã tồn tại.',
            'desc_color.required' => 'Vui lòng nhập tên màu sắc.',
        ]);
        try {
            $color = new Color();
            $color->desc_color = $request->input('desc_color');
            $color->save();
            session()->flash('success', 'Màu sắc đã được thêm thành công');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $color = Color::find($id);

        $productVariants = ProductVariant::where('color_id', $id)->exists();
        $orderDetails = OrderDetail::where('colorid', $id)->exists();

        if ($productVariants) {
            return redirect()->back()->with('error', 'Không thể xóa màu sắc vì màu sắc đang được sử dụng trong sản phẩm.');
        }

        $color->delete();

        return redirect()->back()->with('success', 'Đã xóa màu sắc thành công.');
    }

    public function edit($id)
    {
        $color = Color::find($id);
        $colors = Color::all();

        return view('admin.colors.colors', compact('color', 'colors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'desc_color' => 'required|unique:colors,desc_color,' . $id
        ], [
            'desc_color.unique' => 'Màu sắc này đã tồn tại.',
            'desc_color.required' => 'Vui lòng nhập tên màu sắc.',
        ]);

        try {
            $color = Color::find($id);
            $color->desc_color = $request->input('desc_color');
            $color->save();

            session()->flash('success', 'Màu sắc đã được cập nhật thành công');
            return redirect()->route('admin.colors.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}

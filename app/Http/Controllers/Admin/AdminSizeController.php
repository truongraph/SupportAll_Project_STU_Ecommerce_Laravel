<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Size;
class AdminSizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.sizes', compact('sizes'));
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'desc_size' => 'required|unique:sizes,desc_size'
        ], [
            'desc_size.unique' => 'Kích thước này đã tồn tại.',
            'desc_size.required' => 'Vui lòng nhập tên kích thước.',
        ]);

        try {
            $size = new Size();
            $size->desc_size = $request->input('desc_size');
            $size->save();
            session()->flash('success', 'Kích thước đã được thêm thành công');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $size = Size::find($id);

        $productVariants = ProductVariant::where('size_id', $id)->exists();

        if ($productVariants) {
            return redirect()->back()->with('error', 'Không thể xóa màu sắc vì màu sắc đang được sử dụng trong sản phẩm.');
        }

        $size->delete();

        return redirect()->back()->with('success', 'Đã xóa màu sắc thành công.');
    }

    public function edit($id)
    {
        $size = Size::find($id);
        $sizes = Size::all(); // Đưa danh sách màu sắc để hiển thị hoặc chọn màu sẵn có trong form (tuỳ nhu cầu)

        return view('admin.sizes.sizes', compact('size', 'sizes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'desc_size' => 'required|unique:sizes,desc_size,' . $id
        ], [
            'desc_size.unique' => 'Kích thước này đã tồn tại.',
            'desc_size.required' => 'Vui lòng nhập tên kích thước.',
        ]);

        try {
            $size = Size::find($id);
            $size->desc_size = $request->input('desc_size');
            $size->save();

            session()->flash('success', 'Kích thước đã được cập nhật thành công');
            return redirect()->route('admin.sizes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

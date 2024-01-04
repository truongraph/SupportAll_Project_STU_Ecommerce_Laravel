<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
class AdminCategoryController extends Controller
{

    //============================================
    //============================================
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }
    //============================================
    //============================================
    public function create()
    {
        $parentCategories = Category::where('status_category', 1)
            ->whereNull('id_parent')
            ->get();
        return view('admin.category.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_category' => [
                'required',
                'unique:categories,name_category',
            ],
            'link_category' => 'required',
            'id_parent' => 'nullable|exists:categories,id'

        ], [
            'name_category.required' => 'Vui lòng điền thông tin danh mục.',
            'name_category.unique' => 'Tên danh mục này đã tồn tại, vui lòng nhập tên khác.',
        ]);
        $validatedData['status_category'] = $request->input('status_category', 1);
        try {
            Category::create($validatedData);
            session()->flash('success', 'Danh mục đã được thêm thành công');
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $parentCategories = Category::where('status_category', 1)
            ->whereNull('id_parent')
            ->get();
        return view('admin.category.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {

        $category = Category::findOrFail($id);
        if ($request->input('status_category') == 0 && $category->childCategories()->exists()) {
            return redirect()->back()->with('error', 'Không thể ngừng kích hoạt vì danh mục đang được sử dụng làm danh mục cha cho danh mục khác.');
        }
        $validatedData = $request->validate([
            'name_category' => 'required|unique:categories,name_category,'. $id,
            'link_category' => 'required',
            'id_parent' => 'nullable|exists:categories,id'
        ], [
            'name_category.required' => 'Vui lòng điền thông tin danh mục',
            'name_category.unique' => 'Tên danh mục này đã tồn tại, vui lòng nhập tên khác.'
        ]);

        $validatedData['status_category'] = $request->has('status_category') ? 1 : 0;
        $category->update($validatedData);
        session()->flash('success', 'Chỉnh sửa danh mục thành công');
        return redirect()->route('admin.categories.index');
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Không tìm thấy danh mục');
        }

        $pr_Prodcut = Product::where('id_category',$id)->first();
        if ($pr_Prodcut) {
            return redirect()->back()->with('error', 'Danh mục này có chứa sản phẩm. Vui lòng xóa các sản phẩm con trước khi xóa danh mục này.');
        }

        $childCategories = Category::where('id_parent', $category->id)->first();
        if ($childCategories) {
            return redirect()->back()->with('error', 'Danh mục này có danh mục con. Vui lòng xóa các danh mục con trước khi xóa danh mục này.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Đã xoá danh mục thành công');
    }
}

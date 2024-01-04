<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        // Lọc theo tên
        if ($request->has('name_filter')) {
            $query->where('name_product', 'like', '%' . $request->input('name_filter') . '%');
        }

        // Lọc theo sku
        if ($request->has('sku_filter')) {
            $query->where('sku', 'like', '%' . $request->input('sku_filter') . '%');
        }

        // Lọc theo tên danh mục
        if ($request->has('category_filter')) {
            $category = Category::where('name_category', $request->input('category_filter'))->first();
            if ($category) {
                $query->where('id_category', $category->id);
            }
        }

        // Lọc theo trạng thái
        if ($request->has('status_filter')) {
            $status = $request->input('status_filter');
            if ($status == 'active') {
                $query->where('status_product', 1);
            } elseif ($status == 'inactive') {
                $query->where('status_product', 0);
            }
        }

        if ($request->has('stock_filter')) {
            $stockFilter = $request->input('stock_filter');

            // Lọc theo tồn kho còn hàng
            if ($stockFilter === 'available') {
                $query->whereHas('variants', function ($q) {
                    $q->where('quantity', '>', 0);
                });
            }

            // Lọc theo tồn kho hết hàng
            if ($stockFilter === 'out_of_stock') {
                $query->whereDoesntHave('variants', function ($q) {
                    $q->where('quantity', '>', 0);
                });
            }
        }

        $products = $query->get();
        $categories = Category::whereHas('products')->get();

        foreach ($query as $product) {
            $variants = ProductVariant::where('product_id', $product->id)->get();

            // Tính tổng số lượng tồn kho dựa trên quantity từ các biến thể của sản phẩm
            $totalStock = $variants->sum('quantity');

            // Gán giá trị vào thuộc tính total_stock
            $product->total_stock = $totalStock;
        }
        // Lấy danh sách các danh mục


        return view('admin.products.index', compact('products', 'categories'));
    }


    public function delete($id)
    {
        $orderDetailExists = OrderDetail::where('productid', $id)->exists();

        if ($orderDetailExists) {
            return redirect()->back()->with('error', 'Không thể xóa sản phẩm vì sản phẩm đang có trong đơn hàng');
        }

        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm để xóa.');
        }

        // Lấy đường dẫn đến thư mục chứa hình ảnh của sản phẩm
        $imagePath = public_path('img/products/' . $id);

        // Kiểm tra xem thư mục tồn tại trước khi xóa
        if (file_exists($imagePath)) {
            // Xóa toàn bộ tệp tin trong thư mục
            $files = glob($imagePath . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            // Xóa thư mục chứa hình ảnh
            rmdir($imagePath);
        }

        // Xóa những size và color tương ứng trong bảng ProductVariant
        ProductVariant::where('product_id', $id)->delete();
        // Xóa sản phẩm nếu không có trong OrderDetail
        $product->delete();

        return redirect()->back()->with('success', 'Đã xóa sản phẩm thành công.');
    }
    //============================================
    //============================================
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        $categoriesTree = $this->buildCategoryTree($categories);
        return view('admin.products.create', compact('categoriesTree', 'sizes', 'colors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_product' => [
                'required',
                'unique:products,name_product',
            ],
            'sku' => [
                'required',
                'unique:products,sku',
            ],
            'link_product' => 'required',
            'sortdesc_product' => 'nullable',
            'desc_product' => 'required',
            'price_product' => 'required',
            'sellprice_product' => 'nullable',
            'id_category' => 'required',
        ], [
            'name_product.unique' => 'Tên sản phẩm này đã tồn tại, vui lòng nhập tên khác.',
            'name_product.required' => 'Vui lòng nhập tên sản phẩm.',
            'sku.unique' => 'Mã này đã tồn tại, vui lòng nhập mã khác.',
            'sku.required' => 'Vui lòng nhập mã sản phẩm.',
            'price_product.required' => 'Vui lòng nhập giá bán.',
            'id_category.required' => 'Vui lòng chọn danh mục.',
            'desc_product.required' => 'Vui lòng nhập mô tả cho sản phẩm.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $sellPrice = $request->input('sellprice_product') ? (int) str_replace(',', '', $request->input('sellprice_product')) : min(0, PHP_INT_MAX);
        $product = new Product();
        $product->name_product = $request->input('name_product');
        $product->link_product = $request->input('link_product');
        $product->sku = $request->input('sku');
        $product->sortdesc_product = $request->input('sortdesc_product');
        $product->desc_product = $request->input('desc_product');
        $product->number_buy = 0;
        $product->status_product = 1;
        $product->id_category = $request->input('id_category');
        $product->price_product = (int) str_replace(',', '', $request->input('price_product'));
        $product->sellprice_product = $sellPrice;

        $product->save();

        // // Đảm bảo rằng sản phẩm đã được lưu để có thể lấy được product->id
        // // Tạo thư mục sản phẩm nếu chưa tồn tại
        $path = public_path('img/products/' . $product->id);

        // Kiểm tra xem thư mục đã tồn tại hay chưa, nếu không, hãy tạo nó
        if (!file_exists($path)) {
            // Tạo thư mục mới với quyền truy cập 0755 (có thể bạn cần điều chỉnh quyền truy cập)
            mkdir($path, 0755, true);
        }

        // Lưu ảnh đại diện
        if ($request->hasFile('avt_product')) {
            $image = $request->file('avt_product');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $imageName);

            // Lưu tên hình ảnh vào cột avt_product trong cơ sở dữ liệu
            $product->avt_product = $imageName;

            // Chèn tên hình ảnh của avt_product vào danh sách hình ảnh trong cột image_product
            $imageNames[] = $imageName; // Thêm tên hình ảnh avt_product vào mảng các hình ảnh
        }

        // Lưu album hình ảnh
        if ($request->hasFile('image_product')) {
            $images = $request->file('image_product');

            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $imageName);
                $imageNames[] = $imageName;
            }

            $product->image_product = implode('#', $imageNames);
        }
        $product->save(); // Lưu lại thông tin của sản phẩm sau khi đã cập nhật hình ảnh

        // Xử lý lưu biến thể

        $variants = $request->input('variants');
        if ($variants) {
            foreach ($variants as $variant) {
                $variantData = json_decode($variant, true); // Chuyển đổi từ chuỗi JSON thành mảng

                $productVariant = new ProductVariant();
                $productVariant->product_id = $product->id; // Chỉnh sửa tên của biến $product tương ứng với sản phẩm đang được thêm
                $productVariant->color_id = $variantData['color'];
                $productVariant->size_id = $variantData['size'];
                $productVariant->quantity = $variantData['quantity'];
                $productVariant->save();
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được thêm thành công.');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm để sửa đổi.');
        }

        // Lấy danh mục của sản phẩm dựa trên mối quan hệ trong model Product
        $category = $product->category;

        // Tiếp tục lấy thông tin cần thiết khác
        $sizes = Size::all();
        $colors = Color::all();
        $categories = Category::all();
        $categoriesTree = $this->buildCategoryTree($categories);
        $productVariants = ProductVariant::where('product_id', $product->id)->get();
        return view('admin.products.edit', compact('product', 'category', 'categoriesTree', 'sizes', 'colors', 'productVariants'));
    }
    // Hàm đệ quy để xây dựng cây danh mục theo cấp bậc
    private function buildCategoryTree($categories, $parentId = null)
    {
        $categoryTree = [];
        foreach ($categories as $category) {
            if ($category->id_parent === $parentId) {
                $children = $this->buildCategoryTree($categories, $category->id);
                if ($children) {
                    $category->setAttribute('children', $children);
                }
                $categoryTree[] = $category;
            }
        }
        return $categoryTree;
    }

    public function deleteVariant($id)
    {
        $variantId = (int) $id; 

        $variant = ProductVariant::find($variantId);

        if ($variant) {
            // Kiểm tra xem biến thể có được sử dụng trong OrderDetail hay không
            $usedInOrderDetail = OrderDetail::where('productid', $variant->product_id)
                ->where('sizeid', $variant->size_id)
                ->where('colorid', $variant->color_id)
                ->exists();

            if ($usedInOrderDetail) {
                return response()->json(['error' => 'Không thể xóa biến thể vì nó được sử dụng trong chi tiết đơn'], 400);
            }

            // Nếu không được sử dụng trong OrderDetail, tiến hành xóa biến thể
            $variant->delete();

            // Xoá biến thể thành công, tiến hành làm mới lại danh sách biến thể
            $productId = $variant->product_id;
            $product = Product::with('variants')->find($productId);

            if ($product) {
                $variants = $product->variants;
                // Trả về danh sách biến thể mới sau khi xoá thành công
                return response()->json(['success' => 'Xoá biến thể thành công', 'variants' => $variants]);
            }

            return response()->json(['error' => 'Không tìm thấy sản phẩm sau khi xoá biến thể'], 400);
        }

        return response()->json(['error' => 'Biến thể không tồn tại'], 400);
    }




    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_product' => [
                'required',
                Rule::unique('products')->ignore($id),
            ],
            'sku' => [
                'required',
                Rule::unique('products')->ignore($id),
            ],
            'link_product' => 'required',
            'sortdesc_product' => 'nullable',
            'desc_product' => 'required',
            'price_product' => 'required',
            'sellprice_product' => 'nullable',
            'id_category' => 'required',
        ], [
            'name_product.unique' => 'Tên sản phẩm này đã tồn tại, vui lòng nhập tên khác.',
            'name_product.required' => 'Vui lòng nhập tên sản phẩm.',
            'sku.unique' => 'Mã này đã tồn tại, vui lòng nhập mã khác.',
            'sku.required' => 'Vui lòng nhập mã sản phẩm.',
            'price_product.required' => 'Vui lòng nhập giá bán.',
            'id_category.required' => 'Vui lòng chọn danh mục.',
            'desc_product.required' => 'Vui lòng nhập mô tả cho sản phẩm.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $sellPrice = $request->input('sellprice_product') ? (int) str_replace(',', '', $request->input('sellprice_product')) : min(0, PHP_INT_MAX);
        $product = Product::findOrFail($id);
        // Kiểm tra xem mã giảm có tồn tại không
        if (!$product) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm');
        }
        $oldAvtProduct = $product->avt_product;
        $product->name_product = $request->input('name_product');
        $product->link_product = $request->input('link_product');
        $product->sku = $request->input('sku');
        $product->sortdesc_product = $request->input('sortdesc_product');
        $product->desc_product = $request->input('desc_product');
        $product->id_category = $request->input('id_category');
        $product->price_product = (int) str_replace(',', '', $request->input('price_product'));
        $product->sellprice_product = $sellPrice;


        // Kiểm tra xem ảnh đại diện đã thay đổi hay không
        if ($request->hasFile('avt_product')) {
            // Xóa ảnh đại diện cũ nếu tồn tại
            if ($oldAvtProduct) {
                $oldAvtProductPath = public_path('img/products/' . $id . '/' . $oldAvtProduct);
                if (file_exists($oldAvtProductPath)) {
                    unlink($oldAvtProductPath);
                }

                // Loại bỏ tên ảnh cũ khỏi danh sách image_product
                $imageList = explode('#', $product->image_product);
                $imageList = array_diff($imageList, [$oldAvtProduct]);
                $product->image_product = implode('#', $imageList);
            }

            // Lưu ảnh đại diện mới
            $image = $request->file('avt_product');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/products/' . $id), $imageName);

            $product->avt_product = $imageName;

            // Thêm tên ảnh mới vào danh sách image_product
            $imageList = explode('#', $product->image_product);
            array_unshift($imageList, $imageName); // Thêm tên ảnh mới vào đầu mảng
            $product->image_product = implode('#', $imageList);
        }
        // Xử lý xóa ảnh nếu có
        if ($request->has('removed_images')) {
            $removedImages = $request->input('removed_images');
            foreach ($removedImages as $imageName) {
                // Xóa ảnh từ thư mục
                $imagePath = public_path('img/products/' . $id . '/' . $imageName);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                // Xóa tên ảnh khỏi cột image_product
                $imageProduct = explode('#', $product->image_product);
                $key = array_search($imageName, $imageProduct);
                if ($key !== false) {
                    unset($imageProduct[$key]);
                }
                $product->image_product = implode('#', $imageProduct);
            }
        }

        // Xử lý lưu ảnh mới
        if ($request->hasFile('image_product')) {
            $newImages = $request->file('image_product');
            foreach ($newImages as $newImage) {
                $imageName = time() . '_' . $newImage->getClientOriginalName();
                $newImage->move(public_path('img/products/' . $id), $imageName);

                // Thêm tên ảnh mới vào cột image_product
                $imageProduct = explode('#', $product->image_product);
                $imageProduct[] = $imageName;
                $product->image_product = implode('#', $imageProduct);
            }
        }



        $product->save();

        // Xử lý lưu biến thể
        $variants = $request->input('variants');
        // Xử lý lưu biến thể
        if ($variants) {
            // Lấy danh sách các biến thể được chọn từ giao diện người dùng
            $receivedVariants = collect($variants)->map(function ($variant) {
                return json_decode($variant, true);
            });

            // Lấy danh sách biến thể hiện có trong cơ sở dữ liệu của sản phẩm
            $existingVariants = ProductVariant::where('product_id', $id)->get();

            // Xóa các biến thể không còn được chọn từ cơ sở dữ liệu
            foreach ($existingVariants as $existingVariant) {
                $variantExists = $receivedVariants->contains(function ($receivedVariant) use ($existingVariant) {
                    return $existingVariant->color_id == $receivedVariant['color'] && $existingVariant->size_id == $receivedVariant['size'];
                });

                if (!$variantExists) {
                    $existingVariant->delete();
                }
            }

            // Thêm những biến thể mới
            foreach ($receivedVariants as $receivedVariant) {
                $colorId = intval($receivedVariant['color']);
                $sizeId = intval($receivedVariant['size']);
                $quantity = intval($receivedVariant['quantity']);

                // Kiểm tra xem biến thể đã tồn tại hay chưa
                $existingVariant = ProductVariant::where('product_id', $id)
                    ->where('color_id', $colorId)
                    ->where('size_id', $sizeId)
                    ->first();

                if ($existingVariant) {
                    // Biến thể đã tồn tại, kiểm tra xem số lượng đã được cập nhật chưa
                    if ($existingVariant->quantity != $quantity) {
                        // Nếu số lượng đã cập nhật, cập nhật lại số lượng mới
                        $existingVariant->quantity = $quantity;
                        $existingVariant->save();
                    }
                } else {
                    // Biến thể chưa tồn tại, thêm mới
                    $newVariant = new ProductVariant();
                    $newVariant->product_id = $id;
                    $newVariant->color_id = $colorId;
                    $newVariant->size_id = $sizeId;
                    $newVariant->quantity = $quantity;
                    $newVariant->save();
                }
            }
        }



        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã cập nhật thành công.');
    }


}

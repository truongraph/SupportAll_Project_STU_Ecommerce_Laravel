<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Response;
use Cart;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        $productid = $request->input('product_id');
        $quantity = $request->input('quantity');
        $sizeid = $request->input('size'); // Thêm dòng này để lấy size đã chọn
        $colorid = $request->input('color'); // Thêm dòng này để lấy màu đã chọn
        // Lấy thông tin sản phẩm từ database
        $product = Product::findOrFail($productid);
        // Kiểm tra xem variant có tồn tại và còn hàng không
        $variant = ProductVariant::where('product_id', $productid)
            ->where('size_id', $sizeid)
            ->where('color_id', $colorid)
            ->first();
        if ($variant && $variant->quantity > 0) {
            // Lấy giỏ hàng từ session
            $cart = session()->get('cart', []);
            // Tạo key duy nhất cho sản phẩm trong giỏ hàng với size và color
            $cartKey = $productid . '_' . $sizeid . '_' . $colorid;
            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng hay chưa
            if (isset($cart[$cartKey])) {
                $totalQuantity = $cart[$cartKey]['quantity'] + $quantity;
                if ($totalQuantity > $variant->quantity) {
                    return Response::json(['message' => 'Số lượng tồn không đủ để thêm'], 400);
                }
                $cart[$cartKey]['quantity'] = $totalQuantity;
            } else {
                if ($quantity > $variant->quantity) {
                    return Response::json(['message' => 'Số lượng tồn không đủ để thêm'], 400);
                }
                $cart[$cartKey] = [
                    'name' => $product->name_product,
                    'linkproduct' => $product->link_product,
                    'quantity' => $quantity,
                    'price' => $product->price_product,
                    'sellprice' => $product->sellprice_product,
                    'image' => $product->avt_product,
                    'size' => Size::findOrFail($sizeid)->desc_size,
                    'color' => Color::findOrFail($colorid)->desc_color,
                    'sizeid' => $sizeid,
                    'colorid' => $colorid,
                ];
            }

            // Lưu giỏ hàng mới vào session
            session()->put('cart', $cart);
            return Response::json(['message' => 'Thêm sản phẩm thành công', 'redirect' => route('cart.index')], 200);
        } else {
            // Sản phẩm đã hết hàng hoặc không tồn tại
            return Response::json(['message' => 'Sản phẩm đã hết hàng hoặc không có sẵn'], 404);
        }
    }

    public function removeFromCart(Request $request)
    {
        $productid = $request->input('product_id');
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng hay không
        if (isset($cart[$productid])) {
            // Nếu tồn tại, xóa sản phẩm khỏi giỏ hàng
            unset($cart[$productid]);
            // Lưu giỏ hàng mới vào session
            session()->put('cart', $cart);
            return Response::json(['message' => 'Đã xoá thành công sản phẩm'], 200);
        }
        return Response::json(['message' => 'Sản phẩm không còn tồn tại'], 404);
    }

    public function changeQuantity(Request $request)
    {
        $productid = $request->input('product_id');
        $action = $request->input('action');
        $quantity = $request->input('quantity');
        $cart = session()->get('cart', []);
        if (isset($cart[$productid])) {
            // Lấy sizeid và colorid từ giỏ hàng
            $sizeid = $cart[$productid]['sizeid'];
            $colorid = $cart[$productid]['colorid'];

            $variant = ProductVariant::where('product_id', $productid)
                ->where('size_id', $sizeid)
                ->where('color_id', $colorid)
                ->first();

            if ($variant && $variant->quantity > 0) {
                // Xác định hành động (increase, decrease, update)
                if ($action === 'update') {
                    $totalQuantity = $quantity;
                } elseif ($action == 'increase') {
                    $totalQuantity = $cart[$productid]['quantity'] + 1;
                } elseif ($action == 'decrease') {
                    $totalQuantity = $cart[$productid]['quantity'] - 1;

                    // Kiểm tra nếu số lượng sản phẩm trong giỏ lớn hơn quantity của size và color
                    if ($totalQuantity > $variant->quantity) {
                        // Cập nhật lại quantity của size và color trong giỏ
                        $totalQuantity = $variant->quantity;

                        // Cập nhật quantity trong giỏ hàng
                        $cart[$productid]['quantity'] = $totalQuantity;
                        session()->put('cart', $cart);

                        return Response::json(['message' => 'Số lượng sản phẩm đã được giảm về số lượng có sẵn'], 200);
                    }
                }
                 // Kiểm tra nếu số lượng nhập vào lớn hơn số lượng tồn tại, trả về thông báo lỗi
                 if ($totalQuantity > $variant->quantity) {
                    return Response::json(['message' => 'Số lượng vượt quá số lượng tồn'], 400);
                }
                if ($totalQuantity <= 0) {
                    return Response::json(['message' => 'Số lượng phải lớn hơn 0 '], 400);
                }

                // Cập nhật số lượng sản phẩm trong giỏ hàng
                $cart[$productid]['quantity'] = $totalQuantity;
                session()->put('cart', $cart);

                return Response::json(['message' => 'Thay đổi số lượng thành công'], 200);
            } else {
                return Response::json(['message' => 'Sản phẩm đã hết hàng hoặc không có sẵn'], 404);
            }
        }

        return Response::json(['message' => 'Không tìm thấy sản phẩm trong giỏ'], 404);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            if ($item['sellprice'] > 0) {
                $total += $item['sellprice'] * $item['quantity'];
            } else {
                $total += $item['price'] * $item['quantity'];
            }
        }

        return view('cart.index', compact('cart', 'total'));
    }
   
}

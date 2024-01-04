<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductVariant;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
    public function show($linkProduct)
    {

        $product = Product::where('link_product', $linkProduct)->firstOrFail();
        // Sử dụng mối quan hệ đã được thiết lập để lấy các variants, sizes, và colors
        $variants = $product->variants()->with('size', 'color')->get();
        $sizes = $variants->pluck('size')->unique();
        $colors = $variants->pluck('color')->unique();
        $relatedProducts = $product->getRelatedProducts()->take(5);
        $imagePaths = explode('#', $product->image_product);
        return view('products.show', compact('product', 'sizes', 'colors', 'variants', 'relatedProducts', 'imagePaths'));
    }
}

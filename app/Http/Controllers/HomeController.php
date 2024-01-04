<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('type', 'main')
        ->where('status', 1)
            ->get();
        $secon1Banners = Banner::where('type', 'secon1')
        ->where('status', 1)
            ->get();

        $secon2Banners = Banner::where('type', 'secon2')
        ->where('status', 1)
            ->get();
        $secon3Banners = Banner::where('type', 'secon3')
        ->where('status', 1)
            ->get();

        $secon4Banners = Banner::where('type', 'secon4')
        ->where('status', 1)
            ->get();
        // Lấy các sản phẩm mới nhất
        $newestProducts = Product::orderBy('id', 'desc')->take(5)->get();
        
        // Lấy các sp giảm giá
        $sellProducts = Product::where('sellprice_product', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('home', compact('banners', 'newestProducts', 'sellProducts', 'secon1Banners', 'secon2Banners', 'secon3Banners', 'secon4Banners'));
    }
}

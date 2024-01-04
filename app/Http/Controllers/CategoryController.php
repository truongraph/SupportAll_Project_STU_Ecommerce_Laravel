<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //===================================================
    //===================================================
    public function index(Request $request)
    {
        $categories = Category::where('status_category', 1)->with('products')->get();
        $allProducts = collect();

        foreach ($categories as $category) {
            $allProducts = $allProducts->merge($category->products);
        }

        // Sắp xếp sản phẩm
        $sort = $request->query('sort');
        if ($sort) {
            $sortParts = explode('-', $sort);
            $sortBy = $sortParts[0];
            $sortOrder = isset($sortParts[1]) ? $sortParts[1] : 'asc';

            if ($sortBy === 'number_buy') {
                $allProducts = $allProducts->sortBy('number_buy', SORT_REGULAR, $sortOrder === 'desc');
            } elseif ($sortBy === 'name') {
                $allProducts = $allProducts->sortBy('name_product', SORT_REGULAR, $sortOrder === 'desc');
            }elseif ($sortBy === 'created') {
                $allProducts = $allProducts->sortBy('created_at', SORT_REGULAR, $sortOrder === 'desc');
            }elseif ($sortBy === 'price') {
                $allProducts = $allProducts->sortBy(function ($allProducts) {
                    return $allProducts->sellprice_product > 0 ? $allProducts->sellprice_product : $allProducts->price_product;
                }, SORT_REGULAR, $sortOrder === 'desc');
            }
        }

        // Phân trang
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $pagedData = $allProducts->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $totalItems = $allProducts->count();
        $totalPages = ceil($totalItems / $perPage);

        return view('categories.index', compact('pagedData', 'totalPages', 'currentPage'));
    }
    //===================================================
    //===================================================
    public function show($category, Request $request)
    {
        // Lấy thông tin danh mục theo link
        $category = Category::where('link_category', $category)->with('products')->firstOrFail();

        // Lấy tất cả sản phẩm của danh mục cha và con (nếu có)

        $products = $this->getProductsFromCategoryAndChildCategories($category);

        // Kiểm tra và áp dụng sort nếu có tham số sort từ request
        $sort = $request->query('sort');
        if ($sort) {
            $sortParts = explode('-', $sort);
            $sortBy = $sortParts[0];
            $sortOrder = isset($sortParts[1]) ? $sortParts[1] : 'asc';

            // Sắp xếp sản phẩm
            if ($sortBy === 'number_buy') {
                $products = $products->sortBy('number_buy', SORT_REGULAR, $sortOrder === 'desc');
            } elseif ($sortBy === 'name') {
                $products = $products->sortBy('name_product', SORT_REGULAR, $sortOrder === 'desc');
            } elseif ($sortBy === 'created') {
                $products = $products->sortBy('created_at', SORT_REGULAR, $sortOrder === 'desc');
            }elseif ($sortBy === 'price') {
                $products = $products->sortBy(function ($product) {
                    return $product->sellprice_product > 0 ? $product->sellprice_product : $product->price_product;
                }, SORT_REGULAR, $sortOrder === 'desc');
            }
        }

        $perPage = 10;
        $page = $request->query('page', 1);

        $totalProducts = $products->count();
        $products = $products->slice(($page - 1) * $perPage, $perPage);

        $totalPages = ceil($totalProducts / $perPage);


        return view('categories.show', compact('category', 'products', 'totalPages', 'page'));
    }
    //===================================================
    //===================================================
    private function getProductsFromCategoryAndChildCategories($category)
    {
        $products = $category->products;

        // Nếu danh mục có các danh mục con, lấy sản phẩm của các danh mục con
        if ($category->childCategories) {
            foreach ($category->childCategories as $childCategory) {
                $products = $products->merge($this->getProductsFromCategoryAndChildCategories($childCategory));
            }
        }

        return $products;
    }
}

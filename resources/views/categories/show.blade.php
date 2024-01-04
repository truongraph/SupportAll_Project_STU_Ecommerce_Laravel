@extends('layouts.app')

@section('content')
<!-- breadcrumb-area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- breadcrumb-list start -->
                <ul class="breadcrumb-list">
                    <li class="breadcrumb-item"><a>Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Danh mục sản phẩm</a></li>
                    <li class="breadcrumb-item active">{{ $category->name_category }}</li>
                </ul>

                <!-- breadcrumb-list end -->
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb-area end -->
<!-- main-content-wrap start -->
<div class="main-content-wrap shop-page section-ptb">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <!-- shop-product-wrapper start -->
                <div class="shop-product-wrapper">
                    <div class="row align-itmes-center">
                        <div class="col"><span class="title-shop">Danh mục: {{ $category->name_category }} </span>
                        </div>
                        <div class="col">
                            <!-- product-short start -->
                            <div class="product-short">
                                <select id="sortControl" class="nice-select" onchange="sortby(this.value)">
                                    <option value="number_buy-desc" {{ request()->query('sort') === 'number_buy-desc' ? 'selected' : '' }}>Bán chạy nhất</option>
                                    <option value="name-asc" {{ request()->query('sort') === 'name-asc' ? 'selected' : '' }}>A → Z</option>
                                    <option value="name-desc" {{ request()->query('sort') === 'name-desc' ? 'selected' : '' }}>Z → A</option>
                                    <option value="price-asc" {{ request()->query('sort') === 'price-asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                    <option value="price-desc" {{ request()->query('sort') === 'price-desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                    <option value="created-desc" {{ request()->query('sort') === 'created-desc' ? 'selected' : '' }}>Hàng mới nhất</option>
                                    <option value="created-asc" {{ request()->query('sort') === 'created-asc' ? 'selected' : '' }}>Hàng cũ nhất</option>
                                </select>

                            </div>
                            <!-- product-short end -->
                        </div>
                    </div>
                </div>
                <!-- shop-products-wrap start -->
                <div class="shop-products-wrap" id="list-product">
                    <div class="shop-product-wrap">
                        <div class="row row-8">
                            @forelse($products as $product)
                            <div class="product-col col-6 col-lg-item-5 ">
                                <div class="single-product-wrap mt-10">
                                    <div class="product-image">
                                        <a href="{{ route('products.show', ['linkProduct' => $product->link_product]) }}" title="">
                                            @php
                                            $images = explode(';', $product->image_product);
                                            $firstImage = reset($images);
                                            @endphp
                                            <img src="{{ asset('img/products/' . $product->id . '/' . $firstImage) }}" alt="{{ $product->name_product }}">
                                        </a>
                                        @if ($product->sellprice_product > 0)
                                        <span class="onsale">-{{ round((1 - $product->sellprice_product / $product->price_product) * 100) }}%</span>
                                        @endif
                                    </div>

                                    <div class="product-content">
                                        <h6 class="product-name"><a href="{{ route('products.show', ['linkProduct' => $product->link_product]) }}" title="">{{ $product->name_product }}</a></h6>
                                        <div class="price-box">
                                            @if ($product->sellprice_product > 0)
                                            @php
                                            $formattedPrice = number_format($product->sellprice_product, 0, '.', ',');
                                            $formattedPriceold = number_format($product->price_product, 0, '.', ',');
                                            @endphp
                                            <p class="new-price">{{ $formattedPrice }} đ</p>
                                            <p class="old-price">{{ $formattedPriceold }} đ</p>
                                            @endif
                                            @php
                                            $setemptysell = number_format($product->sellprice_product, 0, '.', ',');
                                            @endphp
                                            @if ($setemptysell === '0')
                                            @php
                                            $formattedPrice = number_format($product->price_product, 0, '.', ',');
                                            @endphp

                                            <p class="new-price">{{ $formattedPrice }} đ</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Product End -->
                            </div>
                            @empty
                            <div class="col-lg-12">
                                <p class="empty_cat">Không tìm thấy sản phẩm. Vui lòng thử lại sau</p>
                            </div>
                            @endforelse
                            <!-- paginatoin-area start -->
                            @if($totalPages >= 1)
                            <div class="paginatoin-area">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <ul class="pagination-box">
                                            @if($page > 1)
                                            <li><a href="{{ route('categories.show', ['category' => $category->link_category]) }}?sort={{ request()->query('sort') }}&page=1">Trang đầu</a></li>
                                            <li><a href="{{ route('categories.show', ['category' => $category->link_category]) }}?sort={{ request()->query('sort') }}&page={{ $page - 1 }}">Trước</a></li>
                                            @endif

                                            @for($i = 1; $i <= $totalPages; $i++) <li class="{{ $page == $i ? 'active' : '' }}"><a href="{{ route('categories.show', ['category' => $category->link_category]) }}?sort={{ request()->query('sort') }}&page={{ $i }}">{{ $i }}</a></li>
                                                @endfor

                                                @if($page < $totalPages) <li><a href="{{ route('categories.show', ['category' => $category->link_category]) }}?sort={{ request()->query('sort') }}&page={{ $page + 1 }}">Sau</a></li>
                                                    <li><a href="{{ route('categories.show', ['category' => $category->link_category]) }}?sort={{ request()->query('sort') }}&page={{ $totalPages }}">Trang cuối</a></li>
                                                    @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- paginatoin-area end -->

                        </div>
                    </div>
                </div>
                <!-- shop-products-wrap end -->

            </div>
        </div>
    </div>
</div>
<!-- main-content-wrap end -->
<script>
    function sortby(value) {
        var url = window.location.href.split('?')[0]; // Lấy URL hiện tại, loại bỏ query parameters
        var queryParams = new URLSearchParams(window.location.search); // Lấy query parameters

        queryParams.set('sort', value); // Đặt tham số sort vào query parameters

        // Thay đổi URL với tham số sort mới
        history.pushState({}, null, `${url}?${queryParams.toString()}`);

        // Tải lại trang với tham số sort mới
        window.location.reload();
    }

</script>
@endsection


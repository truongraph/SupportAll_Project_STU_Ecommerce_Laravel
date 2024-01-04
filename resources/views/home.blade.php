@extends('layouts.app')

@section('content')
    <!-- Hero Section Start -->
    <div class="hero-slider-area">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <div class="hero-slider-wrapper mt-3">

                        <div class="hero-slider-area hero-slider-one swiper mySwiper">
                            <div class="swiper-wrapper gallery-top">
                                @foreach($banners as $banner)
                                <div data-hash="" class="swiper-slide">
                                    <img class="swiper-slide" src="{{ asset('img/banners/main/' . $banner->image) }}"
                                        alt="{{ $banner->type }}">
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->
    <!-- Product Area Start -->
    <div class="product-area section-pt-30 mt-30 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="uppercase">Sản phẩm mới nhất</h3>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>
            <div class="row row-8">
                <!-- Single Product Start -->
                @foreach ($newestProducts as $product)
                    <div class="product-col col-6 col-lg-item-5 ">
                        <div class="single-product-wrap mt-10">
                            <div class="product-image">
                                <a href="{{ route('products.show', ['linkProduct' => $product->link_product]) }}" title="">
                                    <img src="{{ asset('img/products/' . $product->id . '/' . $product->avt_product) }}"
                                        alt="{{ $product->name_product }}">
                                </a>
                                @if ($product->sellprice_product > 0)
                                    <span
                                        class="onsale">-{{ round((1 - $product->sellprice_product / $product->price_product) * 100) }}%</span>
                                @endif
                            </div>

                            <div class="product-content">
                                <h6 class="product-name"><a href="{{ route('products.show', ['linkProduct' => $product->link_product]) }}"
                                        title="">{{ $product->name_product }}</a></h6>
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
                @endforeach
            </div>
        </div>
    </div>
    <!-- Product Area End -->

    <!-- Banner Area Start -->
    <div class="banner-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="single-banner mb-30">
                        @foreach($secon3Banners as $banner)
                        <a href="#"><img class="swiper-slide" src="{{ asset('img/banners/secon3/' . $banner->image) }}" alt=""></a>
                    @endforeach
                    </div>
                </div>
                <div class="col-lg-6  col-md-6">
                    <div class="single-banner mb-30">
                        @foreach($secon4Banners as $banner)
                        <a href="#"><img class="swiper-slide" src="{{ asset('img/banners/secon4/' . $banner->image) }}" alt=""></a>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Area End -->
    <!-- Product Area Start -->
    <div class="product-area section-pt-30 mt-30 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="uppercase">Sản phẩm khuyến mãi</h3>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>
            <div class="row row-8">
                <!-- Single Product Start -->
                @foreach ($sellProducts as $product)
                    <div class="product-col col-6 col-lg-item-5 ">
                        <div class="single-product-wrap mt-10">
                            <div class="product-image">
                                <a href="{{ route('products.show', ['linkProduct' => $product->link_product]) }}" title="">
                                    <img src="{{ asset('img/products/' . $product->id . '/' . $product->avt_product) }}"
                                        alt="{{ $product->name_product }}">
                                </a>
                                @if ($product->sellprice_product > 0)
                                    <span
                                        class="onsale">-{{ round((1 - $product->sellprice_product / $product->price_product) * 100) }}%</span>
                                @endif
                            </div>

                            <div class="product-content">
                                <h6 class="product-name"><a href="{{ route('products.show', ['linkProduct' => $product->link_product]) }}"
                                        title="">{{ $product->name_product }}</a></h6>
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
                @endforeach
            </div>
        </div>
    </div>
    <!-- Product Area End -->
    <!-- Banner Area Start -->
    <div class="banner-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="single-banner mb-30">
                        @foreach($secon1Banners as $banner)
                        <a href="#"><img class="swiper-slide" src="{{ asset('img/banners/secon1/' . $banner->image) }}" alt=""></a>
                    @endforeach
                    </div>
                </div>
                <div class="col-lg-6  col-md-6">
                    <div class="single-banner mb-30">
                        @foreach($secon2Banners as $banner)
                        <a href="#"><img class="swiper-slide" src="{{ asset('img/banners/secon2/' . $banner->image) }}" alt=""></a>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Area End -->
    <br>

@endsection

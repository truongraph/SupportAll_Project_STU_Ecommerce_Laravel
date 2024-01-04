@extends('layouts.app')

@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- breadcrumb-list start -->
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                        @if ($product->category)
                            <li class="breadcrumb-item"><a
                                    href="{{ route('categories.show', $product->category->link_category) }}"
                                    title="">{{ $product->category->name_category }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">{{ $product->name_product }}</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->

    <div class="main-content-wrap shop-page section-ptb">
        <div class="container">
            <div class="row single-product-area product-details-inner">
                <div class="col-lg-5 col-md-6">
                    <!-- Product Details Left -->
                    <div class="stick-gallery">
                        @if ($product->sellprice_product > 0)
                            <span
                                class="sale-flag">-{{ round((1 - $product->sellprice_product / $product->price_product) * 100) }}%</span>
                        @endif
                        <div class="product-large-slider">
                            @foreach ($imagePaths as $imagePath)
                                <div class="pro-large-img img-zoom">
                                    <img src="{{ asset('img/products/' . $product->id . '/' . $imagePath) }}"
                                        alt="product-details" />
                                    <a href="{{ asset('img/products/' . $product->id . '/' . $imagePath) }}"
                                        data-fancybox="images">
                                        <i class='bx bx-zoom-in'></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="product-nav">
                            @foreach ($imagePaths as $imagePath)
                                <div class="pro-nav-thumb">
                                    <img src="{{ asset('img/products/' . $product->id . '/' . $imagePath) }}"
                                        alt="product-details" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!--// Product Details Left -->
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="product-details-view-content">
                        <div class="product-info">
                            <h3>{{ $product->name_product }}</h3>
                            <ul class="stock-cont">
                                <li class="product-sku">Danh mục: <span>{{ $product->category->name_category }}</span></li>
                                <li class="product-sku">Mã: <span>{{ $product->sku }}</span></li>
                                <li class="product-sku">Tình trạng:
                                    @php
                                        $allVariantsEmpty = true;
                                        foreach ($variants as $variant) {
                                            if ($variant->quantity > 0) {
                                                $allVariantsEmpty = false;

                                                break;
                                            }
                                        }

                                    @endphp
                                    @if ($allVariantsEmpty)
                                        <span class="text-danger">Hết hàng</span>
                                    @else
                                        <span class="text-success">Còn hàng </span>
                                    @endif
                                </li>
                                {{-- @php
                                    $totalQuantity = 0;
                                    foreach ($variants as $variant) {
                                        $totalQuantity += $variant->quantity;
                                    }
                                @endphp

                                <li class="product-sku"> Tình trạng:
                                    @if ($totalQuantity > 0)
                                        <span class="text-success">Còn {{ $totalQuantity }} sản phẩm</span>
                                    @else
                                        <span class="text-danger">Hết hàng</span>
                                    @endif
                                </li> --}}
                            </ul>

                            <div class="price-box">
                                @if ($product->sellprice_product > 0)
                                    @php
                                        $formattedPrice = number_format($product->sellprice_product, 0, '.', ',');
                                        $formattedPriceold = number_format($product->price_product, 0, '.', ',');
                                    @endphp
                                    <p class="old-price">{{ $formattedPriceold }} đ</p>
                                    <p class="new-price">{{ $formattedPrice }} đ</p>
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
                            <p class="short_desc">{{ $product->shortdesc_product }}</p>
                            <form id="addToCartForm" action="{{ route('cart.add') }}" method="post">
                                @csrf
                                <div class="item-select-variant mb-20">
                                    <h6 class="title" for="size">Kích thước</h6>
                                    <div class="color-select">
                                        @foreach ($sizes as $size)
                                            @php
                                                $available = false;
                                            @endphp
                                            @foreach ($variants as $variant)
                                                @if ($variant->size_id === $size->id && $variant->quantity > 0)
                                                    @php
                                                        $available = true;
                                                    @endphp
                                                @break
                                            @endif
                                        @endforeach
                                        @if ($available)
                                            <div class="size-option" data-size="{{ $size->id }}">
                                                {{ $size->desc_size }}
                                            </div>
                                        @else
                                            <!-- Đổi div thành span để không cho phép chọn -->
                                            <span class="size-option out-of-stock" data-size="{{ $size->id }}">
                                                {{ $size->desc_size }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="item-select-variant mb-20">
                                <h6 class="title" for="color">Màu sắc</h6>
                                <div class="color-select">
                                    @foreach ($colors as $color)
                                        @php
                                            $available = false;
                                        @endphp
                                        @foreach ($variants as $variant)
                                            @if ($variant->color_id === $color->id && $variant->quantity > 0)
                                                @php
                                                    $available = true;
                                                @endphp
                                            @break
                                        @endif
                                    @endforeach
                                    @if ($available)
                                        <div class="color-option" data-color="{{ $color->id }}">
                                            {{ $color->desc_color }}
                                        </div>
                                    @else
                                        <!-- Đổi div thành span để không cho phép chọn -->
                                        <span class="color-option out-of-stock" data-color="{{ $color->id }}">
                                            {{ $color->desc_color }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="item-select-variant mb-20">
                            <span>
                                <h6 class="title" for="color">Số lượng</h6>
                                <span id="stockInfo" class="stock-info" style="font-size: 13px"></span>
                            </span>
                            <div class="media-total" bis_skin_checked="1">
                                <div class="item-qty" style="width: 120px;" bis_skin_checked="1">
                                    <div class="quantity" bis_skin_checked="1">
                                        <input class="cart-plus-minus-box quantity-input" type="number"
                                            name="quantity" id="quantity" value="1">
                                        <div class="quantity-nav" bis_skin_checked="1">
                                            <button class="changeQuantity quantity-button quantity-up"
                                                type="button" id="increaseQuantity" bis_skin_checked="1">+</button>
                                            <button class="changeQuantity quantity-button quantity-down"
                                                type="button" id="decreaseQuantity" bis_skin_checked="1">-</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </div>
                            </div>
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="huongdanchonsize" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            Hướng dẫn chọn size
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Hướng dẫn chọn size
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body mb-4">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="aothun-tab"
                                                    data-bs-toggle="tab" data-bs-target="#aothun-tab-pane"
                                                    type="button" role="tab" aria-controls="aothun-tab-pane"
                                                    aria-selected="true">Áo thun</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="aokhoac-tab" data-bs-toggle="tab"
                                                    data-bs-target="#aokhoac-tab-pane" type="button"
                                                    role="tab" aria-controls="aokhoac-tab-pane"
                                                    aria-selected="false">Áo khoác</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="quan-tab" data-bs-toggle="tab"
                                                    data-bs-target="#quan-tab-pane" type="button" role="tab"
                                                    aria-controls="quan-tab-pane" aria-selected="false">Quần
                                                    kaki</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="aothun-tab-pane"
                                                role="tabpanel" aria-labelledby="aothun-tab" tabindex="0">
                                                <p class="title-hd"> Đối với áo thun</p>
                                                <img class ="img-huongdanchonsize"
                                                    src="{{ asset('frontend_area/assets/img/hdaothun.webp') }}"
                                                    alt="">
                                            </div>
                                            <div class="tab-pane fade" id="aokhoac-tab-pane" role="tabpanel"
                                                aria-labelledby="aokhoac-tab" tabindex="0">
                                                <p class="title-hd"> Đối với áo khoác</p>
                                                <img class ="img-huongdanchonsize"
                                                    src="{{ asset('frontend_area/assets/img/hdaokhoac.webp') }}"
                                                    alt="">
                                            </div>
                                            <div class="tab-pane fade" id="quan-tab-pane" role="tabpanel"
                                                aria-labelledby="quan-tab" tabindex="0">
                                                <p class="title-hd"> Đối với quần</p>
                                                <img class ="img-huongdanchonsize"
                                                    src="{{ asset('frontend_area/assets/img/hdquankaki.webp') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-add-to-cart d-flex">
                            <button class="add-to-cart" type="submit">Thêm vào giỏ hàng</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="product-description-area section-pt">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-details-tab">
                            <ul role="tablist" class="nav">
                                <li class="active" role="presentation">
                                    <a data-bs-toggle="tab" role="tab" href="#description" class="active">Mô
                                        tả sản phẩm</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="product_details_tab_content tab-content">
                            <!-- Start Single Content -->
                            <div class="product_tab_content tab-pane active" id="description" role="tabpanel">
                                <div class="product_description_wrap  mt-30">
                                    <div class="product_desc mb-30">
                                        {!! $product->desc_product !!}
                                    </div>

                                </div>
                            </div>
                            <!-- End Single Content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




<script>
    // Xử lý tăng giảm số lượng
    var quantityInput = document.getElementById('quantity');
    var decreaseButton = document.getElementById('decreaseQuantity');
    var increaseButton = document.getElementById('increaseQuantity');
    decreaseButton.addEventListener('click', function() {
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    });
    increaseButton.addEventListener('click', function() {
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });
</script>
{{-- ======================================================================= --}}
{{-- ======================================================================= --}}
{{-- ======================================================================= --}}
<script>
    //===========================================================
    // Khai báo các biến lưu trữ thông tin về size và color được chọn
    //===========================================================
    let selectedSize = null;
    let selectedColor = null;
    //===========================================================
    // Biến lưu trữ số lượng sản phẩm theo từng size và color
    //===========================================================
    let quantityBySizeAndColor = {};
    //===========================================================
    // Biến lưu trữ thông tin về các size có sẵn cho từng màu
    //===========================================================
    let availableSizesByColor = {};
    //===========================================================
    //===========================================================
    // Hàm cập nhật thông tin số lượng sản phẩm và kích thước có sẵn cho từng màu sắc và size
    //===========================================================
    //===========================================================
    function updateAvailableOptions() {
        quantityBySizeAndColor = {};
        availableSizesByColor = {};
        // Lặp qua các variant để cập nhật thông tin số lượng và kích thước có sẵn
        @foreach ($variants as $variant)
            // Kiểm tra và lưu số lượng sản phẩm theo từng size và color
            if (!quantityBySizeAndColor[{{ $variant->color_id }}]) {
                quantityBySizeAndColor[{{ $variant->color_id }}] = {};
            }
            quantityBySizeAndColor[{{ $variant->color_id }}][{{ $variant->size_id }}] = {{ $variant->quantity }};
            // Kiểm tra và lưu thông tin về các size có sẵn cho từng màu
            if (!availableSizesByColor[{{ $variant->color_id }}]) {
                availableSizesByColor[{{ $variant->color_id }}] = [];
            }
            availableSizesByColor[{{ $variant->color_id }}].push({{ $variant->size_id }});
        @endforeach
    }
    //===========================================================
    //===========================================================
    // Gọi hàm cập nhật thông tin số lượng sản phẩm và kích thước có sẵn khi trang được load
    //===========================================================
    //===========================================================
    document.addEventListener('DOMContentLoaded', function() {
        updateAvailableOptions();
        updateSelectedOptions();
    });
    //===========================================================
    //===========================================================
    // Hàm cập nhật trạng thái cho các tùy chọn size và color dựa trên thông tin đã cập nhật
    //===========================================================
    //===========================================================
    function updateSelectedOptions() {
        // Tổng số lượng sản phẩm của tất cả các biến thể
        let allVariantsQuantity = Object.values(quantityBySizeAndColor).reduce((acc, val) => acc.concat(Object.values(
            val)), []);
        let totalQuantity = allVariantsQuantity.reduce((acc, val) => acc + val, 0);

        // Cập nhật trạng thái cho tùy chọn size
        document.querySelectorAll('.size-option').forEach(function(sizeOption) {
            let size = sizeOption.dataset.size;

            // Kiểm tra nếu tổng số lượng là 0 hoặc size không có sẵn cho màu đã chọn thì đánh dấu là hết hàng
            if (totalQuantity === 0 || (selectedColor !== null && availableSizesByColor[selectedColor].indexOf(
                    parseInt(size)) === -1)) {
                sizeOption.classList.add('out-of-stock');
            } else {
                sizeOption.classList.remove('out-of-stock');
            }

            // Nếu size không có số lượng tồn kho, đánh dấu là hết hàng và disable tùy chọn size đó
            if (selectedColor !== null && selectedColor in quantityBySizeAndColor && size in
                quantityBySizeAndColor[selectedColor] && quantityBySizeAndColor[selectedColor][size] === 0) {
                sizeOption.classList.add('out-of-stock');
                // Thêm thuộc tính disabled để disable tùy chọn
                sizeOption.setAttribute('disabled', 'disabled');
            } else {
                // Bỏ thuộc tính disabled nếu quantity > 0
                sizeOption.removeAttribute('disabled');
            }
        });

        // Cập nhật trạng thái cho tùy chọn color
        document.querySelectorAll('.color-option').forEach(function(colorOption) {
            let color = colorOption.dataset.color;

            // Kiểm tra nếu tổng số lượng là 0 hoặc màu không có sẵn cho size đã chọn thì đánh dấu là hết hàng
            if (totalQuantity === 0 || (selectedSize !== null && !quantityBySizeAndColor[color][
                    selectedSize
                ])) {
                colorOption.classList.add('out-of-stock');
            } else {
                colorOption.classList.remove('out-of-stock');
            }

            // Kiểm tra nếu không có size nào của màu có số lượng tồn kho, đánh dấu là hết hàng và disable tùy chọn màu đó
            let hasAvailableQuantity = Object.keys(quantityBySizeAndColor[color]).some(function(sizeKey) {
                return quantityBySizeAndColor[color][sizeKey] > 0;
            });

            if (!hasAvailableQuantity) {
                colorOption.classList.add('out-of-stock');
                // Thêm thuộc tính disabled để disable tùy chọn màu không có quantity > 0
                colorOption.setAttribute('disabled', 'disabled');
            } else {
                // Bỏ thuộc tính disabled nếu có ít nhất một size có quantity > 0
                colorOption.removeAttribute('disabled');
            }
        });
    }
    //===========================================================
    //===========================================================
    //Sự kiện khi chọn kích thước
    //===========================================================
    //===========================================================
    document.querySelectorAll('.size-option').forEach(function(sizeOption) {
        // Thêm sự kiện click cho từng tùy chọn size
        sizeOption.addEventListener('click', function() {
            // Kiểm tra nếu size đang được chọn bằng với size đã được chọn trước đó
            if (selectedSize === this.dataset.size) {
                // Nếu trùng thì bỏ chọn size đó
                selectedSize = null;
            } else {
                // Nếu không trùng thì chọn size này và gán vào biến selectedSize
                selectedSize = this.dataset.size;
            }
            // Cập nhật trạng thái các tùy chọn size và color dựa trên thông tin đã chọn
            updateSelectedOptions();
            document.querySelectorAll('.size-option').forEach(function(option) {
                // Loại bỏ 'selected-option' cho tất cả các tùy chọn size
                option.classList.remove('selected-option');
            });
            if (selectedSize !== null) {
                // Nếu đã chọn size mới, thêm CSS 'selected-option' cho tùy chọn đó
                this.classList.add('selected-option');
            }
            // Cập nhật thông tin số lượng còn hàng dựa trên size và color đã chọn
            updateStockInfo();
        });
    });
    //===========================================================
    //===========================================================
    //Sự kiện khi chọn màu
    //===========================================================
    //===========================================================
    document.querySelectorAll('.color-option').forEach(function(colorOption) {
        colorOption.addEventListener('click', function() {
            if (selectedColor === this.dataset.color) {
                selectedColor = null;
            } else {
                selectedColor = this.dataset.color;
            }
            updateSelectedOptions();
            document.querySelectorAll('.color-option').forEach(function(option) {
                option.classList.remove('selected-option');
            });
            if (selectedColor !== null) {
                this.classList.add('selected-option');
            }
            updateStockInfo();
        });
    });
    //===========================================================
    //===========================================================
    // Cập nhật thông tin số lượng còn hàng
    //===========================================================
    //===========================================================
    function updateStockInfo() {
        let stockInfo = document.getElementById('stockInfo');
        if (selectedSize !== null && selectedColor !== null) {
            let quantity = quantityBySizeAndColor[selectedColor][selectedSize];
            stockInfo.innerText = `(Còn ${quantity} sản phẩm)`;
        } else {
            stockInfo.innerText = '';
        }
    }
    //===========================================================
    //===========================================================
    // Xử lý thêm vào giỏ hàng
    //===========================================================
    //===========================================================
    document.getElementById('addToCartForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let allVariantsEmpty = true;
        // Kiểm tra xem tất cả các biến thể có quantity > 0 không
        for (let variant in quantityBySizeAndColor) {
            for (let size in quantityBySizeAndColor[variant]) {
                if (quantityBySizeAndColor[variant][size] > 0) {
                    allVariantsEmpty = false;
                    break;
                }
            }
        }

        // Nếu tất cả đều hết hàng, hiển thị thông báo và ngăn người dùng thêm vào giỏ hàng
        if (allVariantsEmpty) {
            toastr.error('Sản phẩm này đã hết hàng');
            return;
        }

        if (selectedColor === null && selectedColor === null) {
            toastr.error('Vui lòng chọn đầy đủ kích thước và màu');
            return;
        }
        if (selectedSize === null) {
            toastr.error('Vui lòng chọn kích thước');
            return;
        }
        if (selectedColor === null) {
            toastr.error('Vui lòng chọn màu sắc');
            return;
        }
        let quantityInput = document.getElementById('quantity');
        let quantityToAdd = parseInt(quantityInput.value);

        // Kiểm tra số lượng nhập vào có hợp lệ không
        if (quantityBySizeAndColor[selectedColor][selectedSize] < quantityToAdd) {
            toastr.error('Số lượng đang vượt quá số lượng tồn');
            return;
        }

        let formData = new FormData(this);
        formData.append('size', selectedSize);
        formData.append('color', selectedColor);
        axios.post('/cart/add', formData)
        .then(function(response) {
            let message = response.data.message;
            if (message) {
                toastr.success(message);
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            }
        })
        .catch(function(error) {
            let errorMessage = error.response.data.error; // Lấy thông báo lỗi từ response
            if (errorMessage) {
                toastr.error(errorMessage); // Hiển thị thông báo lỗi bằng toast
            } else {
                console.error(error); // Log lỗi nếu không có thông báo lỗi từ controller
            }
        });
    });
</script>
@endsection

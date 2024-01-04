@extends('layouts.app')

@section('content')
<!-- breadcrumb-area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- breadcrumb-list start -->
                <ul class="breadcrumb-list">
                    <li class="breadcrumb-item"><a href="">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Giỏ hàng </li>
                </ul>
                <!-- breadcrumb-list end -->
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb-area end -->
<div class="wrapper-mainCart">
    <div class="content-bodyCart">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12 contentCart-detail">
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                    <div class="mainCart-detail">
                        <div class="heading-cart">
                            <h1>Giỏ hàng của bạn</h1>
                        </div>
                        @if(count($cart) > 0)
                        <div class="list-pageform-cart">
                            <form action="#">
                                <div class="cart-row">
                                    <p class="title-number-cart">
                                        Bạn đang có <strong class="count-cart">{{ count(session('cart', [])) }} sản
                                            phẩm</strong> trong giỏ hàng
                                    </p>
                                    <div class="table-cart">
                                        @foreach($cart as $cartKey => $item)
                                        @php
                                        // Tách các giá trị từ key
                                        list($productid, $sizeid, $colorid) = explode('_', $cartKey);
                                        @endphp
                                        <div class="media-line-item line-item">
                                            <div class="media-left">
                                                <div class="item-img">
                                                    <a href="{{ route('products.show', ['linkProduct' => $item['linkproduct']]) }}">
                                                        <img src="{{ asset('img/products/' . $productid . '/' . $item['image']) }}" alt="">
                                                    </a>
                                                </div>
                                                <div class="item-remove">
                                                    <a class="removeFromCart" data-product="{{ $cartKey }}"><i class='bx bx-trash'></i></a>
                                                </div>
                                            </div>
                                            <div class="media-right">
                                                <div class="item-info">
                                                    <h3 class="item--title"><a href="{{ route('products.show', ['linkProduct' => $item['linkproduct']]) }}">{{ $item['name']
                                                            }}</a></h3>
                                                </div>
                                                <div class="item-price">
                                                    <div class="price-box" style="display: flex;gap:10px">
                                                        @if ($item['sellprice'] > 0)
                                                        @php
                                                        $formattedPrice = number_format($item['sellprice'], 0, '.',
                                                        ',');
                                                        $formattedPriceold = number_format($item['price'], 0, '.', ',');
                                                        @endphp
                                                        <p class="new-price">{{ $formattedPrice }} đ</p>
                                                        <del class="old-price">{{ $formattedPriceold }} đ</del>
                                                        @endif
                                                        @php
                                                        $setemptysell = number_format($item['sellprice'], 0, '.', ',');
                                                        @endphp
                                                        @if ($setemptysell === '0')
                                                        @php
                                                        $formattedPrice = number_format($item['price'], 0, '.', ',');
                                                        @endphp

                                                        <p class="new-price">{{ $formattedPrice }} đ</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="item-info">
                                                    <h3 class="item--title">{{ $item['color'] }} - {{ $item['size'] }}</h3>
                                                </div>
                                            </div>
                                            <div class="item-total-price">
                                                <span class="line-item-total">
                                                    @if ($item['sellprice'] > 0)
                                                    @php
                                                    $formattedPrice = number_format($item['quantity'] * $item['sellprice'], 0, '.',
                                                    ',');
                                                    $formattedPriceold = number_format($item['price'], 0, '.', ',');
                                                    @endphp
                                                    {{ $formattedPrice }} đ
                                                    @endif
                                                    @php
                                                    $setemptysell = number_format($item['sellprice'], 0, '.', ',');
                                                    @endphp
                                                    @if ($setemptysell === '0')
                                                    @php
                                                    $formattedPrice = number_format($item['quantity'] * $item['price'], 0, '.', ',');
                                                    @endphp
                                                    {{ $formattedPrice }} đ
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="media-total" bis_skin_checked="1">
                                                <div class="item-qty" style="width: 120px;" bis_skin_checked="1">
                                                    <div class="quantity" bis_skin_checked="1">
                                                        <input class="cart-plus-minus-box quantity-input" type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="100" data-product="{{ $cartKey }}">
                                                        <div class="quantity-nav" bis_skin_checked="1">
                                                            <div class="changeQuantity quantity-button quantity-up" data-product="{{ $cartKey }}" data-action="increase" bis_skin_checked="1">+</div>
                                                            <div class="changeQuantity quantity-button quantity-down" data-product="{{ $cartKey }}" data-action="decrease" bis_skin_checked="1">-</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                            </form>
                        </div> @else
                        <div class="expanded-message text-center">Giỏ hàng của bạn đang trống</div>
                        @endif
                    </div>
                    <a class="continue-btn" href="{{ route('categories.index') }}">Tiếp tục mua hàng</a>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 sidebarCart-sticky">
                    <div class="mainCart-sidebar wrap-order-summary">
                        <div class="order-summary-block">
                            <h2 class="summary-title">Thông tin đơn hàng</h2>

                            <div class="summary-time summary-picktime">
                                <div class="summary-time__row">
                                    <div class="boxtime-title">
                                        <p class="txt-title">Tạm tính</p>
                                    </div>
                                    <div class="boxtime-radio" id="picktime_radio">
                                        <div class="radio-item">
                                            {{ number_format($total) }} đ
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="summary-total">
                                <p>Tổng thành tiền:
                                    <span>{{ number_format($total) }} đ</span>
                                </p>
                            </div>
                            <div class="summary-action">
                                @if(count($cart) > 0)
                                <div class="summary-warning  alert-order " style="display:block;margin-top:10px;">
                                    Bạn có thể nhập mã giảm giá sản phẩm ở trang thanh toán tiếp theo
                                </div>
                                <div class="summary-button">
                                    <a id="btnCart-checkout" class="checkout-btn btnred" href="{{ route('checkout.index') }}">THANH
                                        TOÁN </a>
                                </div>
                                @else
                                <div class="summary-alert  alert-danger " style="display:block;margin-top:10px">
                                    Giỏ hàng của bạn hiện chưa có sản phẩm để tiến hành thanh toán
                                </div>
                                <div class="summary-button">
                                    <a id="btnCart-checkout" class="checkout-btn btnred disabled">THANH TOÁN </a>
                                </div>
                                @endif


                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('.quantity-input').on('input', function() {
        var inputElement = $(this);
        var newQuantity = inputElement.val();
        var productid = inputElement.data('product');
        var originalQuantity = inputElement.attr('value');

        if (newQuantity < 1 || isNaN(newQuantity)) {
            newQuantity = originalQuantity;
            inputElement.val(newQuantity);
            return;
        }

        axios.post('/cart/change-quantity', {
                product_id: productid
                , action: 'update'
                , quantity: newQuantity
            })
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
                let errorMessage = error.response.data.message;
                if (errorMessage) {
                    toastr.error(errorMessage);
                } else {
                    console.error(error);
                }
                inputElement.val(originalQuantity);
            });
    });


    // Script để xử lý Ajax khi nhấn nút thay đổi số lượng
    var changeQuantityButtons = document.querySelectorAll('.changeQuantity');
    var removeButtons = document.querySelectorAll('.removeFromCart');

    changeQuantityButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var productid = this.getAttribute('data-product');
            var action = this.getAttribute('data-action');
            var quantityInput = document.querySelector(`.quantity-input[data-product="${productid}"]`);

            // Kiểm tra nếu action là giảm và số lượng là 1 thì không thực hiện gì cả
            if (action === 'decrease' && quantityInput.value == 1) {
                return;
            }

            // Gửi Ajax request để thay đổi số lượng sản phẩm trong giỏ hàng
            axios.post('/cart/change-quantity', {
                    product_id: productid
                    , action: action
                })
                .then(function(response) {
                    let message = response.data.message;
                    if (message) {
                        toastr.success(message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                })
                .catch(function(error) {
                    let errorMessage = error.response.data.message; // Lấy thông báo lỗi từ response
                    if (errorMessage) {
                        toastr.error(errorMessage); // Hiển thị thông báo lỗi bằng toast
                    } else {
                        console.error(error); // Log lỗi nếu không có thông báo lỗi từ controller
                    }
                });
        });
    });

    //Xử lý xóa sản phẩm
    removeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var productid = this.getAttribute('data-product');

            // Hiển thị cửa sổ xác nhận sử dụng SweetAlert2
            Swal.fire({
                text: "Bạn chắc chắn muốn bỏ sản phẩm này?"
                , icon: false
                , showCancelButton: true
                , confirmButtonText: 'Đồng ý'
                , cancelButtonText: 'Hủy bỏ'
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
            , }).then(function(result) {
                if (result.isConfirmed) {
                    // Nếu người dùng xác nhận xóa sản phẩm
                    axios.delete('/cart/remove', {
                            data: {
                                product_id: productid
                            }
                        })
                        .then(function(response) {
                            let message = response.data.message;
                            if (message) {
                                toastr.success(message);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        })
                        .catch(function(error) {
                            let errorMessage = error.response.data.message; // Lấy thông báo lỗi từ response
                            if (errorMessage) {
                                toastr.error(errorMessage); // Hiển thị thông báo lỗi bằng toast
                            } else {
                                console.error(error); // Log lỗi nếu không có thông báo lỗi từ controller
                            }
                        });
                }
            });
        });
    });

</script>
@endsection



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
        Cửa hàng quần áo
    </title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('frontend_area/assets/css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('frontend_area/assets/css/vendor/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend_area/assets/css/vendor/plaza-font.css') }}">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('frontend_area/assets/css/plugins/slick.css') }}">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <!--  CSS STYLE -->
    <link href="{{ asset('frontend_area/assets/css/style-themes.scss.css') }}" rel="preload stylesheet" as="style"
        type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend_area/assets/css/plugins/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend_area/assets/css/plugins/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend_area/assets/css/plugins/fancy-box.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend_area/assets/css/plugins/jqueryui.min.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend_area/assets/css/style.css') }}">
    <!-- ======================================================================================================================== -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- ✅ load jQuery ✅ -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- ✅ load JS for Select2 ✅ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('frontend_area/assets/css/checkout-style.css') }}">
    <!-- ======================================================================================================================== -->
</head>

<body class="cms-index-index cms-home-page">
<form id="checkoutForm" action="{{ route('checkout.process') }}" method="post">
    @csrf
    <div class="content">
        <div class="wrap">
            <div class="sidebar" style="margin-top: 60px">
                <div class="sidebar-content">
                    <div class="order-summary order-summary-is-collapsed">
                        <h2 class="visually-hidden">Thông tin đơn hàng</h2>
                        <div class="order-summary-sections">
                            <div class="order-summary-section order-summary-section-product-list" data-order-summary-section="line-items">
                                <table class="product-table">
                                    <thead>
                                        <tr>
                                            <th scope="col"><span class="visually-hidden">Hình ảnh</span></th>
                                            <th scope="col"><span class="visually-hidden">Mô tả</span></th>
                                            <th scope="col"><span class="visually-hidden">Số lượng</span></th>
                                            <th scope="col"><span class="visually-hidden">Giá</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart as $cartKey => $item)
                                        @php
                                        // Tách các giá trị từ key
                                        list($productid, $sizeid, $colorid) = explode('_', $cartKey);
                                        @endphp
                                        <tr class="product">
                                            <td class="product-image">
                                                <div class="product-thumbnail">
                                                    <div class="product-thumbnail-wrapper">
                                                        <img class="product-thumbnail-image" src="{{ asset('img/products/' . $productid . '/' . $item['image']) }}"
                                                            alt="">
                                                    </div>
                                                    <span class="product-thumbnail-quantity" aria-hidden="true"> {{ $item['quantity'] }}</span>
                                                </div>
                                            </td>
                                            <td class="product-description">
                                                <p class="product-description-name order-summary-emphasis mb-10"> {{ $item['name'] }}</p>
                                                <span class="product-description-name order-summary-emphasis">{{ $item['color'] }} - {{ $item['size'] }}</span>
                                            </td>
                                            <td class="product-quantity visually-hidden"> {{ $item['quantity'] }}</td>

                                            <td class="product-price">
                                                <span class="order-summary-emphasis">
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
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="order-summary-section order-summary-section-discount">
                                <input name="utf8" type="hidden" value="✓">
                                <div class="fieldset">
                                    <div class="field  ">
                                        <div class="field-input-btn-wrapper">
                                            <div class="field-input-wrapper">
                                                <label class="field-label" for="discount_code">Mã giảm giá</label>
                                                <input name="discount_code" id="discount_code" placeholder="Mã giảm giá" class="field-input" autocomplete="false" autocapitalize="off" spellcheck="false" size="30" />
                                            </div>
                                            <button type="button" id="apply_discount_button" class="field-input-btn btn-default">
                                                <span class="btn-content">Sử dụng</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-summary-section order-summary-section-total-lines payment-lines">
                                <table class="total-line-table">
                                    <thead>
                                        <tr>
                                            <th scope="col"><span class="visually-hidden">Mô tả</span></th>
                                            <th scope="col"><span class="visually-hidden">Giá</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="total-line total-line-subtotal">
                                            <td class="total-line-name">Tạm tính</td>
                                            <td class="total-line-price">
                                                <span class="order-summary-emphasis">
                                                    {{ number_format($total) }} đ
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="total-line total-line-shipping">
                                            <td class="total-line-name">Mã giảm giá</td>
                                            <td class="total-line-price d-flex gap-3" style="justify-content: end;">
                                            <span class="order-summary-emphasis">
                                                {{-- <p id="discount_info"></p> --}}
                                                <p id="discount_money" style="font-weight:700;color: red;"></p>
                                             </span>
                                             <button style="position:relative;top: -1px;color: red;cursor: pointer;" type="button" id="remove_discount_button"><i class="bx bxs-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <tfoot class="total-line-table-footer">

                                        <tr class="total-line">
                                            <td class="total-line-name payment-due-label">
                                                <span class="payment-due-label-total">Tổng cộng</span>
                                            </td>
                                            <td class="total-line-name payment-due">
                                                <p id="total" class="payment-due-price">
                                                    {{ number_format($total) }} đ
                                                </p>
                                                <input type="hidden" name="total_price" id="total_price" value="{{ $total }}">
                                                <span class="checkout_version" display:none data_checkout_version="1">
                                                </span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="section-content">
                                    <div class="content-box">
                                        @foreach($paymentmethods as $paymentmethod)
                                        <div class="radio-wrapper content-box-row">
                                            <label class="two-page" for="{{ $paymentmethod->id }}">
                                                <div class="radio-input payment-method-checkbox">
                                                    <input value="{{ $paymentmethod->id }}" id="{{ $paymentmethod->id }}" class="input-radio" name="payment_method" type="radio" checked="{{ $paymentmethod->id }}">
                                                </div>
                                                <div class="radio-content-input">
                                                    <div class="content-wrapper">
                                                        <span class="radio-label-primary">{{ $paymentmethod->name_payment }}</span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                    </div>
                                    <p style="margin: 15px 0px;color:red;font-weight:500;text-align:center">*Lưu ý: Vui lòng kiểm tra kỹ thông tin trước khi nhấn đặt hàng</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="main-header">

                    <a class="logo" href="{{URL::to('/')}}">

                        <h1 class="logo-text">Cửa hàng quần áo</h1>

                    </a>

                    <style>
                        a.logo {
                            display: block;
                            margin: 0px;
                        }

                        .logo-cus {
                            width: 100%;
                            padding: 15px 0;

                        }

                        .logo-cus img {
                            max-height: 4.2857142857em
                        }


                        @media (max-width: 767px) {
                            .banner a {
                                display: block;
                            }
                        }
                    </style>


                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/cart') }}">Giỏ hàng</a>
                        </li>
                        <li class=" breadcrumb-item-current">

                            Thông tin giao hàng

                        </li>

                    </ul>

                </div>
                <div class="main-content">
                    <div class="step">
                        <div class="section">

                            <div class="section-header">
                                <h2 class="section-title">Thông tin giao hàng</h2>
                            </div>

                            <div class="section-content section-customer-information no-mb">

                                        @if(session()->has('account_id'))
                                                    <div></div>
                                            @else
                                            <p class="section-content-text">
                                                Bạn có tài khoản?
                                                <a href="{{ route('login') }}">Ấn vào đây để đăng nhập</a>
                                                </p>
                                       @endif

                                       @if(session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                       @endif
                                       @if(session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                       @endif

                                <div class="fieldset">
                                    <div class="field">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="name">Họ và tên</label>
                                            <input type="text" name="name" value="{{ !session()->has('account_id') ? ($customerInfo ? $customerInfo->name_customer : old('name')) : '' }}"  class="field-input" placeholder="Họ và tên">
                                        </div>

                                    </div>

                                    <div class="field  field-half ">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="checkout_user_email">Email</label>
                                            <input type="text" name="email" value="{{ !session()->has('account_id') ? ($customerInfo ? $customerInfo->email_customer : old('email')) : '' }}"  class="field-input" placeholder="Email">
                                        </div>

                                    </div>

                                    <div class="field field-required field-half  ">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="billing_address_phone">Số điện thoại</label>
                                            <input type="number" name="phone" value="{{ !session()->has('account_id') ? ($customerInfo ? $customerInfo->phone_customer : old('phone')) : '' }}"  class="field-input" placeholder="Số điện thoại">
                                        </div>

                                    </div>
                                    <div class="field   ">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="billing_address_address1">Địa chỉ</label>
                                            <input name="address" value="{{ !session()->has('account_id') ? ($customerInfo ? $customerInfo->address_customer : old('address')) : '' }}"  placeholder="Địa chỉ giao hàng" class="field-input" style="height: auto !important;" />
                                        </div>

                                    </div>
                                    <div class="field">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="notes">Nội dung giao hàng</label>
                                            <textarea name="note" placeholder="Ghi chú giao hàng" class="field-input" rows="4" style="height:auto !important;" value="{{ old('note') }}"></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="step-footer">
                                    <button type="submit" class="step-footer-continue-btn"><span class="btn-content">Hoàn tất đặt hàng</span></button>
                                <a class="step-footer-previous-link" href="{{ url('/cart') }}">
                                    Trở về giỏ hàng
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('.alert-danger').delay(5000).fadeOut('slow');
    $(document).ready(function() {
        var originalTotal = {{ $total }};
        var hasDiscountApplied = {{ session()->has('original_total') ? 'true' : 'false' }};
        // Ẩn nút gỡ mã giảm giá khi ban đầu
        $('#remove_discount_button').hide();
        $('#apply_discount_button').click(function(event) {
            event.preventDefault();
            var discountCode = $('#discount_code').val();

            if (!discountCode) {
                toastr.error('Vui lòng nhập mã giảm giá');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('apply.discount') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    discount_code: discountCode
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        var newTotal = response.totalPrice;
                        $('#total').text(number_format(newTotal) + ' đ');
                        $('#total_price').val(newTotal);
                        if (response.discountName && response.discountAmount) {
                            var discountInfo = response.discountName;
                            var discountMoney = response.discountAmount;
                            $('#discount_info').text(discountInfo);
                            $('#discount_money').text(number_format(discountMoney) + ' đ');
                            $('#remove_discount_button').show();
                        }
                    } else {
                        toastr.error(response.message);
                        $('#total').text(number_format(originalTotal) + ' đ');
                        $('#total_price').val(originalTotal);
                        $('#discount_info').text(''); // Xóa thông tin về mã giảm giá
                        $('#discount_money').text('');
                        if (!response.hasDiscountApplied) {
                            $('#remove_discount_button').hide(); // Ẩn nút gỡ mã nếu không có mã áp dụng
                        }
                        $('#discount_code').val('');
                    }
                },
                error: function() {
                    toastr.error('Lỗi áp dụng mã giảm giá');
                }
            });
        });

        $('#remove_discount_button').click(function(event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('remove.discount') }}',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        // Cập nhật lại số tiền trên giao diện với originalTotal
                        var newTotal = response.originalTotal;
                        $('#total').text(number_format(newTotal) + ' đ');
                        $('#total_price').val(newTotal);
                        $('#discount_info').text(''); // Xóa thông tin về mã giảm giá
                        $('#discount_money').text('');
                        if (!response.hasDiscountApplied) {
                            $('#remove_discount_button').hide(); // Ẩn nút gỡ mã nếu không có mã áp dụng
                        }
                        $('#discount_code').val('');
                    } else {
                        toastr.error('Gỡ mã giảm giá không thành công');
                    }
                },
                error: function() {
                    toastr.error('Lỗi khi gỡ mã giảm giá');
                }
            });
        });
    });




    function number_format(number) {
        return new Intl.NumberFormat('vi-VN').format(number).replace(/\./g, ",");;
    }



</script>
  <!-- ======================================================================================================================== -->
    <!-- JS  -->
    <!-- Modernizer JS -->
    <script src="{{ asset('frontend_area/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Add this at the end of the file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('frontend_area/assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('frontend_area/assets/js/vendor/bootstrap.min.js') }}"></script>

    <!-- Plugins JS -->
    <script src="{{ asset('frontend_area/assets/js/plugins/slick.min.js') }}"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontend_area/assets/js/plugins/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend_area/assets/js/plugins/countdown.min.js') }}"></script>
    <script src="{{ asset('frontend_area/assets/js/plugins/image-zoom.min.js') }}"></script>
    <script src="{{ asset('frontend_area/assets/js/plugins/fancybox.js') }}"></script>
    <script src="{{ asset('frontend_area/assets/js/plugins/scrollup.min.js') }}"></script>
    <script src="{{ asset('frontend_area/assets/js/plugins/jqueryui.min.js') }}"></script>
    <script src="{{ asset('frontend_area/assets/js/plugins/ajax-contact.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('frontend_area/assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('js/custom-owl.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            var sticky = $('#myHeader'),
                scroll = $(window).scrollTop();
        });
        toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': false,
            'progressBar': false,
            'positionClass': 'toast-top-right',
            'preventDuplicates': false,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '5000',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut',
        }
    </script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            hashNavigation: {
                watchState: true,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
        $('.error').delay(3000).hide(0);
        $('.alert').delay(3000).hide(0);
    </script>

</body>

</html>




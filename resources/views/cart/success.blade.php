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
    <div class="content">
        <div class="wrap">
            <div class="sidebar">
                <div class="sidebar-content">
                    <div class="order-summary order-summary-is-collapsed">
                        <h2 class="visually-hidden">Thông tin đơn hàng</h2>
                        <div class="order-summary-sections">
                            <div class="order-summary-section order-summary-section-product-list">
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
                                        @foreach($orderDetails as $detail)
                                        <tr class="product">
                                            <td class="product-image">
                                                <div class="product-thumbnail">
                                                    <div class="product-thumbnail-wrapper">
                                                        <img class="product-thumbnail-image" src="{{ asset('img/products/' . $detail->product->id . '/' . $detail->product->avt_product) }}"
                                                        alt="">
                                                    </div>
                                                    <span class="product-thumbnail-quantity" aria-hidden="true">{{ $detail->quantity }}</span>
                                                </div>
                                            </td>
                                            <td class="product-description">
                                                <span class="product-description-name order-summary-emphasis">{{ $detail->product->name_product }}</span>
                                                <span class="product-description-name order-summary-emphasis">{{ $detail->sizes->desc_size }} - {{ $detail->colors->desc_color }}</span>
                                            </td>
                                            <td class="product-quantity visually-hidden">{{ $detail->quantity }}</td>
                                            <td class="text-center" style="display: none;">
                                                {{ number_format($detail->totalprice) }} đ
                                            </td>
                                            <td class="product-price">
                                                <span class="order-summary-emphasis">{{ number_format($detail->totalprice) }} đ</span>
                                            </td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
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
                                            <td class="total-line-name">Tổng cộng</td>
                                            <td class="total-line-price">
                                                <span class="order-summary-emphasis">
                                                    @if($order->discount_code && $order->discount)
                                                        <span style="float: right;">{{ number_format($order->total_order + $order->discount->discount) }} đ</span>
                                                    @else
                                                    <span style="float: right;">{{ number_format($order->total_order) }} đ</span>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="total-line total-line-subtotal">
                                            <td class="total-line-name">Mã giảm giá</td>
                                            <td class="total-line-price">
                                                <span class="order-summary-emphasis">
                                                    @if($order->discount_code && $order->discount)
                                                    <span style="float: right;">- {{ number_format($order->discount->discount) }} đ</span>
                                                @else
                                                    <span style="float: right;">Không có mã giảm giá</span>
                                                @endif
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <tfoot class="total-line-table-footer">

                                        <tr class="total-line">
                                            <td class="total-line-name payment-due-label">
                                                <span class="payment-due-label-total">Tổng tiền thanh toán</span>
                                            </td>
                                            <td class="total-line-name payment-due">
                                                <span class="payment-due-price">
                                                    {{ number_format($order->total_order) }} đ
                                                </span>
                                                <span class="checkout_version" display:none data_checkout_version="1">
                                                </span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                @if($order->paymentmethod->name_payment !== "Thanh toán khi nhận hàng")
                                    <hr style="border: 1px dashed rgb(131, 131, 131); margin: 25px auto">
                                    <div class="mb-3">
                                        <h2 class="title-cart mb-2">Tài khoản ngân hàng</h2>
                                        <p class="mb-2" style="color: #000;"><strong style="color:red">*Nội dung chuyển khoản:</strong> Mã đơn hàng và Số điện thoại</p>
                                        <span class="mb-2" style="color: #000;"><i class='bx bx-copy' ></i> Copy nội dung chuyển khoản: <a href="" style="color:green"><strong>{{ $order->code_order }}va{{ $order->phone_order }}</strong></a></span>
                                        <p class="mt-2">- Trước hoặc sau khi chuyển khoản. Vui lòng chụp lại thông tin chuyển khoản và liên hệ cho cửa hàng qua số hotline:<strong style="color:red">0789703120</strong> để được xác nhận đơn hàng</p>
                                    </div>
                                    <table class="table table-bordered p-10 bg-white">
                                        <tr>
                                            <th style="width: 200px;padding:5px">Tên ngân hàng</th>
                                            <th style="width: 100px;padding:5px">Số tài khoản</th>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px">
                                                <p >Ngân Hàng Tiên Phong Bank</p>
                                                <strong style="margin-top: 7px;">Chi nhánh: Bình Tân</strong>
                                            </td>
                                            <td style="padding:5px">68695696789</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:5px">
                                                <p>Momo</p>
                                            </td>
                                            <td style="padding:5px">0789703120</td>
                                        </tr>
                                    </table>
                                    <p>
                                        <div style="font-size: 11px;text-align:center;margin-top:30px;">
                                            <p><i>Mọi thắc mắc xin hãy liên hệ về hotline: 0789703120</i></p>
                                            <p><i> Địa chỉ : 180 Cao Lỗ, P.4, Q.8, HCM</i></p>
                                        </div>
                                    </p>
                                    @else
                                    <p>
                                        <div style="font-size: 11px;text-align:center;margin-top:50px;">
                                            <p><i>Mọi thắc mắc xin hãy liên hệ về hotline: 0789703120</i></p>
                                            <p><i> Địa chỉ : 180 Cao Lỗ, P.4, Q.8, HCM</i></p>
                                        </div>
                                    </p>
                                @endif
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

                            Hoàn tất đặt hàng

                        </li>

                    </ul>

                </div>
                <div class="main-content">
                    <div class="step">
                        <div class="section">
                            <div class="section-header">
                                <h2 class="section-title"><i class='bx bx-check-circle'></i> Đặt hàng thành công</h2>

                            </div>
                            <div class="tks-header">
                                <p>Mã đơn hàng #{{ $order->code_order }}</p>
                                <p>Cám ơn bạn đã mua hàng!</p>
                                <h3> Chúng tôi đã gởi thông tin đơn hàng đến
                                    {{ $order->email_order }}. Vui lòng theo dõi đơn hàng của bạn tại email.
                                </h3>
                            </div>
                            <div class="section-content section-customer-information no-mb">
                                <table class="table tks-tabele-info-cus">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <h2 class="title-cart">THÔNG TIN ĐẶT HÀNG</h2>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="200px"><strong>Ngày đặt hàng :</strong></td>
                                            <td>  {{ $formattedDate }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200px"><strong>Tên khách hàng :</strong></td>
                                            <td>{{ $order->name_order }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200px"><strong>Số điện thoại :</strong></td>
                                            <td>{{ $order->phone_order }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200px"><strong>Địa chỉ nhận hàng :</strong></td>
                                            <td>{{ $order->address_order }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200px"><strong>Phương thức thanh toán :</strong></td>
                                            <td>{{ $order->paymentmethod->name_payment }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200px"><strong>Ghi chú giao hàng :</strong></td>
                                            <td>{{ $order->note }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="step-footer">
                                <a class="step-footer-continue-btn" href="{{ route('categories.index') }}">Tiếp tục mua hàng</a>
                                <a class="step-footer-previous-link" href="{{URL::to('/lienhe')}}">
                                    <i class='bx bx-headphone'></i> Liên hệ hỗ trợ
                                </a>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
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
        $('.error').delay(2000).hide(0);
        $('.alert').delay(2000).hide(0);
    </script>

</body>

</html>

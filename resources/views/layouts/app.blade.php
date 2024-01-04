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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <!-- ======================================================================================================================== -->
</head>

<body class="cms-index-index cms-home-page">

    <div class='thetop'></div>
    <!-- Header -->
    <header class="header">
        <div class="haeader-mid-area bg-gren d-none border-bm-1 d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-5">
                        <div class="logo-area  d-mt-30">
                            <a href="{{URL::to('/')}}"><img src="{{URL::to('frontend_area/assets/img/logo.webp')}}"
                                    alt="Logo"></a>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="search-box-wrapper full_width">
                            <div class="search-box-inner-wrap">
                                <form class="search-box-inner" action="{{ url('/search') }}" method="GET" role="form">
                                    <div class="search-field-wrap">
                                        <input type="text" class="search-field" name="query"
                                            placeholder="Nhập tên sản phẩm cần tìm...">
                                        <div class="search-btn">
                                            <button type="submit"><i class="icon-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="right-blok-box text-white d-flex">
                            <div class="box-cart-wrap">
                                <div class="shopping-cart-wrap account_box">
                                    <a class='d-block d-lg-none' >
                                        <<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 22 22">
                                            <path
                                                d="M14.5156 12.875C15.9479 12.875 17.1719 13.3958 18.1875 14.4375C19.2292 15.4531 19.75 16.6771 19.75 18.1094V19.125C19.75 19.6458 19.5677 20.0885 19.2031 20.4531C18.8385 20.8177 18.3958 21 17.875 21H4.125C3.60417 21 3.16146 20.8177 2.79688 20.4531C2.43229 20.0885 2.25 19.6458 2.25 19.125V18.1094C2.25 16.6771 2.75781 15.4531 3.77344 14.4375C4.8151 13.3958 6.05208 12.875 7.48438 12.875C7.82292 12.875 8.31771 12.9792 8.96875 13.1875C9.64583 13.3958 10.3229 13.5 11 13.5C11.6771 13.5 12.3542 13.3958 13.0312 13.1875C13.7083 12.9792 14.2031 12.875 14.5156 12.875ZM17.875 19.125V18.1094C17.875 17.1979 17.5365 16.4167 16.8594 15.7656C16.2083 15.0885 15.4271 14.75 14.5156 14.75C14.4375 14.75 14.0208 14.8542 13.2656 15.0625C12.5365 15.2708 11.7812 15.375 11 15.375C10.2188 15.375 9.45052 15.2708 8.69531 15.0625C7.96615 14.8542 7.5625 14.75 7.48438 14.75C6.57292 14.75 5.77865 15.0885 5.10156 15.7656C4.45052 16.4167 4.125 17.1979 4.125 18.1094V19.125H17.875ZM14.9844 10.6094C13.8906 11.7031 12.5625 12.25 11 12.25C9.4375 12.25 8.10938 11.7031 7.01562 10.6094C5.92188 9.51562 5.375 8.1875 5.375 6.625C5.375 5.0625 5.92188 3.73438 7.01562 2.64062C8.10938 1.54688 9.4375 1 11 1C12.5625 1 13.8906 1.54688 14.9844 2.64062C16.0781 3.73438 16.625 5.0625 16.625 6.625C16.625 8.1875 16.0781 9.51562 14.9844 10.6094ZM13.6562 3.96875C12.9271 3.23958 12.0417 2.875 11 2.875C9.95833 2.875 9.07292 3.23958 8.34375 3.96875C7.61458 4.69792 7.25 5.58333 7.25 6.625C7.25 7.66667 7.61458 8.55208 8.34375 9.28125C9.07292 10.0104 9.95833 10.375 11 10.375C12.0417 10.375 12.9271 10.0104 13.6562 9.28125C14.3854 8.55208 14.75 7.66667 14.75 6.625C14.75 5.58333 14.3854 4.69792 13.6562 3.96875Z">
                                            </path></svg>
                                    </a>
                                    <a class='d-none d-lg-block'><svg
                                            xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 22 22">
                                            <path
                                                d="M14.5156 12.875C15.9479 12.875 17.1719 13.3958 18.1875 14.4375C19.2292 15.4531 19.75 16.6771 19.75 18.1094V19.125C19.75 19.6458 19.5677 20.0885 19.2031 20.4531C18.8385 20.8177 18.3958 21 17.875 21H4.125C3.60417 21 3.16146 20.8177 2.79688 20.4531C2.43229 20.0885 2.25 19.6458 2.25 19.125V18.1094C2.25 16.6771 2.75781 15.4531 3.77344 14.4375C4.8151 13.3958 6.05208 12.875 7.48438 12.875C7.82292 12.875 8.31771 12.9792 8.96875 13.1875C9.64583 13.3958 10.3229 13.5 11 13.5C11.6771 13.5 12.3542 13.3958 13.0312 13.1875C13.7083 12.9792 14.2031 12.875 14.5156 12.875ZM17.875 19.125V18.1094C17.875 17.1979 17.5365 16.4167 16.8594 15.7656C16.2083 15.0885 15.4271 14.75 14.5156 14.75C14.4375 14.75 14.0208 14.8542 13.2656 15.0625C12.5365 15.2708 11.7812 15.375 11 15.375C10.2188 15.375 9.45052 15.2708 8.69531 15.0625C7.96615 14.8542 7.5625 14.75 7.48438 14.75C6.57292 14.75 5.77865 15.0885 5.10156 15.7656C4.45052 16.4167 4.125 17.1979 4.125 18.1094V19.125H17.875ZM14.9844 10.6094C13.8906 11.7031 12.5625 12.25 11 12.25C9.4375 12.25 8.10938 11.7031 7.01562 10.6094C5.92188 9.51562 5.375 8.1875 5.375 6.625C5.375 5.0625 5.92188 3.73438 7.01562 2.64062C8.10938 1.54688 9.4375 1 11 1C12.5625 1 13.8906 1.54688 14.9844 2.64062C16.0781 3.73438 16.625 5.0625 16.625 6.625C16.625 8.1875 16.0781 9.51562 14.9844 10.6094ZM13.6562 3.96875C12.9271 3.23958 12.0417 2.875 11 2.875C9.95833 2.875 9.07292 3.23958 8.34375 3.96875C7.61458 4.69792 7.25 5.58333 7.25 6.625C7.25 7.66667 7.61458 8.55208 8.34375 9.28125C9.07292 10.0104 9.95833 10.375 11 10.375C12.0417 10.375 12.9271 10.0104 13.6562 9.28125C14.3854 8.55208 14.75 7.66667 14.75 6.625C14.75 5.58333 14.3854 4.69792 13.6562 3.96875Z">
                                            </path>
                                        </svg></a>

                                    <ul class="mini-cart">
                                        <li class="mini-cart-btns">
                                            <div class="cart-btns">
                                                @if(session()->has('account_id'))
                                                     <a class='login-b' href="{{ route('myaccount') }}"><i class='bx bxs-user-circle'></i> Quản lý tài khoản</a>
                                                    <a href="{{ route('logout') }}"><i class='bx bxs-log-in-circle' ></i> Đăng xuất</a>
                                                @else
                                                    <a class='login-b' href="{{ route('login') }}">Đăng nhập tài khoản</a>
                                                    <a href="{{ route('register') }}">Tạo tài khoản mới</a>
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="box-cart-wrap">

                                <div class="shopping-cart-wrap">
                                    <!-- ================================== -->
                                    <a class="d-block d-lg-none" href="{{ url('/cart') }}"><span class="cart-total">
                                            {{ count(session('cart', [])) }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 22 22">
                                            <path
                                                d="M15.95 6H19.7V17.875C19.7 18.7344 19.3875 19.4635 18.7625 20.0625C18.1635 20.6875 17.4344 21 16.575 21H5.325C4.46563 21 3.72344 20.6875 3.09844 20.0625C2.49948 19.4635 2.2 18.7344 2.2 17.875V6H5.95C5.95 4.61979 6.43177 3.44792 7.39531 2.48438C8.3849 1.49479 9.56979 1 10.95 1C12.3302 1 13.5021 1.49479 14.4656 2.48438C15.4552 3.44792 15.95 4.61979 15.95 6ZM13.1375 3.8125C12.5385 3.1875 11.8094 2.875 10.95 2.875C10.0906 2.875 9.34844 3.1875 8.72344 3.8125C8.12448 4.41146 7.825 5.14062 7.825 6H14.075C14.075 5.14062 13.7625 4.41146 13.1375 3.8125ZM17.825 17.875V7.875H15.95V9.4375C15.95 9.69792 15.8589 9.91927 15.6766 10.1016C15.4943 10.2839 15.2729 10.375 15.0125 10.375C14.7521 10.375 14.5307 10.2839 14.3484 10.1016C14.1661 9.91927 14.075 9.69792 14.075 9.4375V7.875H7.825V9.4375C7.825 9.69792 7.73385 9.91927 7.55156 10.1016C7.36927 10.2839 7.14792 10.375 6.8875 10.375C6.62708 10.375 6.40573 10.2839 6.22344 10.1016C6.04115 9.91927 5.95 9.69792 5.95 9.4375V7.875H4.075V17.875C4.075 18.2135 4.19219 18.5 4.42656 18.7344C4.68698 18.9948 4.98646 19.125 5.325 19.125H16.575C16.9135 19.125 17.2 18.9948 17.4344 18.7344C17.6948 18.5 17.825 18.2135 17.825 17.875Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <!-- ================================== -->
                                    <a class="d-none d-lg-block" href="{{ url('/cart') }}"> <svg
                                            xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 22 22">
                                            <path
                                                d="M15.95 6H19.7V17.875C19.7 18.7344 19.3875 19.4635 18.7625 20.0625C18.1635 20.6875 17.4344 21 16.575 21H5.325C4.46563 21 3.72344 20.6875 3.09844 20.0625C2.49948 19.4635 2.2 18.7344 2.2 17.875V6H5.95C5.95 4.61979 6.43177 3.44792 7.39531 2.48438C8.3849 1.49479 9.56979 1 10.95 1C12.3302 1 13.5021 1.49479 14.4656 2.48438C15.4552 3.44792 15.95 4.61979 15.95 6ZM13.1375 3.8125C12.5385 3.1875 11.8094 2.875 10.95 2.875C10.0906 2.875 9.34844 3.1875 8.72344 3.8125C8.12448 4.41146 7.825 5.14062 7.825 6H14.075C14.075 5.14062 13.7625 4.41146 13.1375 3.8125ZM17.825 17.875V7.875H15.95V9.4375C15.95 9.69792 15.8589 9.91927 15.6766 10.1016C15.4943 10.2839 15.2729 10.375 15.0125 10.375C14.7521 10.375 14.5307 10.2839 14.3484 10.1016C14.1661 9.91927 14.075 9.69792 14.075 9.4375V7.875H7.825V9.4375C7.825 9.69792 7.73385 9.91927 7.55156 10.1016C7.36927 10.2839 7.14792 10.375 6.8875 10.375C6.62708 10.375 6.40573 10.2839 6.22344 10.1016C6.04115 9.91927 5.95 9.69792 5.95 9.4375V7.875H4.075V17.875C4.075 18.2135 4.19219 18.5 4.42656 18.7344C4.68698 18.9948 4.98646 19.125 5.325 19.125H16.575C16.9135 19.125 17.2 18.9948 17.4344 18.7344C17.6948 18.5 17.825 18.2135 17.825 17.875Z">
                                            </path>
                                        </svg><span class="cart-total">
                                            {{ count(session('cart', [])) }}</span></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- haeader bottom Start -->
            <div class="haeader-bottom-area bg-gren header-sticky">
                <div class="container container-menu">
                    <div class="row align-items-center">
                        <div class="col-lg-12 d-none d-lg-block">
                            <div class="main-menu-area white_text">
                                <!--  Start Mainmenu Nav-->
                                <nav class="main-navigation">
                                    @include('layouts.menu')
                                </nav>

                            </div>
                        </div>

                        <div class="col-5 col-md-6 d-block d-lg-none">
                            <div class="logo"><a href="{{URL::to('/')}}"><img src="public/images/logo.webp"
                                        alt="Logo"></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-7">
                            <div class="right-blok-box text-white d-block d-lg-none d-flex">

                                <div class="user-wrap">
                                    <div class="shopping-cart-wrap">
                                        <a class='d-block d-lg-none'><i class='bx bx-user-circle'></i></a>
                                        <ul class="mini-cart">
                                            <li class="mini-cart-btns">
                                                <div class="cart-btns">
                                                    <!-- <a href='thongtincanhan.html'><i class='bx bxs-user-circle'></i> Quản lý tài khoản</a>
                                                    <a href='dang-xuat'><i class='bx bxs-log-in-circle' ></i> Đăng xuất</a> -->
                                                    <a class='login-b' href="{{ route('login') }}">Đăng nhập tài khoản</a>
                                                    <a href="{{ route('register') }}">Tạo tài khoản mới</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="shopping-cart-wrap">
                                    <!-- ================================== -->
                                    <a class="d-block d-lg-none"><span class="cart-total">
                                        {{ count(session('cart', [])) }}</span>
                                        <i class='bx bx-shopping-bag'></i>
                                    </a>
                                </div>
                                <div class="mobile-menu-btn ">
                                    <div class="off-canvas-btn">
                                        <a><i class='bx bx-menu'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- haeader bottom End -->
    </header>
    <div class="page-area">
        @yield('content')
    </div>
    <footer>
        <div class="footer-top section-pb section-pt-60">
            <div class="container">
                <div class="row" >
                    <div class="col-lg-4">
                        <div class="widget-footer ">
                            <h6 class="title-widget">Thông tin liên hệ</h6>
                            <ul class="footer-list">
                                <li class="clearfix">
                                    <i class='bx bx-map'></i>
                                    <span>180 Cao Lỗ, P.14, Q.8, TP.HCM</span>
                                </li>
                                <li class="clearfix">
                                    <i class='bx bx-phone'></i>
                                    <span>Tổng đài hỗ trợ: 0789 703 120 (8:30 - 17:30)</span>
                                </li>
                                <li class="clearfix">
                                    <i class='bx bx-mail-send'></i>
                                    <span><a href="mailto:huy07112000@gmail.com">huy07112000@gmail.com</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6" style="margin-left: 100px">
                        <div class="widget-footer ">
                            <h6 class="title-widget">Liên kết</h6>
                            <ul class="footer-list">
                                <li><a href="/">Trang chủ</a></li>
                                <li><a href="/ve-chung-toi">Về chúng tôi</a></li>
                                <li><a href="/categories">Sản phẩm</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6" style="margin-left: 100px">
                        <div class="widget-footer ">
                            <h6 class="title-widget">Hỗ trợ</h6>
                            <ul class="footer-list">
                                <li><a href="#">Chính sách mua hàng</a></li>
                                <li><a href="#">Hỗ trợ mua hàng</a></li>
                                <li><a href="/lienhe">Liên hệ giải đáp</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="copy-left-text">
                            <p>Copyright &copy; <a href="#">Cửa hàng quần áo ToranoShop</a> 2023. All Right Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ======================================================================================================================== -->
    <!-- JS  -->
    <!-- Modernizer JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var successAlert = document.querySelector('.alert');

            if (successAlert) {
                setTimeout(function() {
                    successAlert.classList.add('d-none');
                }, 4000);
            }
        });
    </script>
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
        $('.error').delay(4000).hide(0);
        $('.alert').delay(4000).hide(0);
    </script>

</body>

</html>

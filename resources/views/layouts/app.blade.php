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
    <link href="{{ asset('frontend_area/assets/css/style-themes.scss.css') }}" rel="preload stylesheet" as="style" type="text/css">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- ✅ load JS for Select2 ✅ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                    <div class="col-xl-2 col-lg-2 col-md-4 col-5">
                        <div class="logo-area  d-mt-30">
                            <a href="{{URL::to('/')}}"><img class="w-full" src="{{URL::to('frontend_area/assets/img/pharmacity-logo.svg')}}" alt="Logo"></a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="search-box-wrapper full_width">
                            <div class="search-box-inner-wrap">
                                <form class="search-box-inner" action="{{ url('/search') }}" method="GET" role="form">
                                    <div class="search-field-wrap">
                                        <input type="text" class="search-field" name="query" placeholder="Tên thuốc, triệu chứng, vitamin và thực phẩm chức năng">
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
                                    <!-- <a class='d-block d-lg-none' href='thongtincanhan.html'><i class='bx bx-user-circle' ></i></a>
                                        <a class='d-none d-lg-block' href='thongtincanhan.html'><i class='bx bxs-user-circle'></i> <span class='cart-total-amunt'>Tài khoản của tôi</span></a> -->
                                    <a class='d-block d-lg-none'>
                                        <svg width="22" height="22" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20.0711 4.92895C18.1823 3.0402 15.6711 2 13 2C10.3289 2 7.8177 3.0402 5.92891 4.92895C4.0402 6.8177 3 9.32891 3 12C3 14.6711 4.0402 17.1823 5.92891 19.0711C7.8177 20.9598 10.3289 22 13 22C15.6711 22 18.1823 20.9598 20.0711 19.0711C21.9598 17.1823 23 14.6711 23 12C23 9.32891 21.9598 6.8177 20.0711 4.92895ZM13 20.8281C10.3879 20.8281 8.03762 19.6874 6.41984 17.8785C7.42277 15.2196 9.99016 13.3281 13 13.3281C11.0584 13.3281 9.48438 11.7541 9.48438 9.8125C9.48438 7.87086 11.0584 6.29688 13 6.29688C14.9416 6.29688 16.5156 7.87086 16.5156 9.8125C16.5156 11.7541 14.9416 13.3281 13 13.3281C16.0098 13.3281 18.5772 15.2196 19.5802 17.8785C17.9624 19.6874 15.6121 20.8281 13 20.8281Z" fill="currentColor"></path>
                                        </svg>
                                    </a>
                                    <a class='d-none d-lg-block'><div class="d-flex-item">
                                        <svg width="25" height="25" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20.0711 4.92895C18.1823 3.0402 15.6711 2 13 2C10.3289 2 7.8177 3.0402 5.92891 4.92895C4.0402 6.8177 3 9.32891 3 12C3 14.6711 4.0402 17.1823 5.92891 19.0711C7.8177 20.9598 10.3289 22 13 22C15.6711 22 18.1823 20.9598 20.0711 19.0711C21.9598 17.1823 23 14.6711 23 12C23 9.32891 21.9598 6.8177 20.0711 4.92895ZM13 20.8281C10.3879 20.8281 8.03762 19.6874 6.41984 17.8785C7.42277 15.2196 9.99016 13.3281 13 13.3281C11.0584 13.3281 9.48438 11.7541 9.48438 9.8125C9.48438 7.87086 11.0584 6.29688 13 6.29688C14.9416 6.29688 16.5156 7.87086 16.5156 9.8125C16.5156 11.7541 14.9416 13.3281 13 13.3281C16.0098 13.3281 18.5772 15.2196 19.5802 17.8785C17.9624 19.6874 15.6121 20.8281 13 20.8281Z" fill="currentColor"></path>
                                        </svg>Đăng nhập/Đăng ký</div></a>

                                    <ul class="mini-cart">
                                        <li class="mini-cart-btns">
                                            <div class="cart-btns">
                                                @if(session()->has('account_id'))
                                                <a class='login-b' href="{{ route('myaccount') }}"><i class='bx bxs-user-circle'></i> Quản lý tài khoản</a>
                                                <a href="{{ route('logout') }}"><i class='bx bxs-log-in-circle'></i> Đăng xuất</a>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                            <path d="M15.95 6H19.7V17.875C19.7 18.7344 19.3875 19.4635 18.7625 20.0625C18.1635 20.6875 17.4344 21 16.575 21H5.325C4.46563 21 3.72344 20.6875 3.09844 20.0625C2.49948 19.4635 2.2 18.7344 2.2 17.875V6H5.95C5.95 4.61979 6.43177 3.44792 7.39531 2.48438C8.3849 1.49479 9.56979 1 10.95 1C12.3302 1 13.5021 1.49479 14.4656 2.48438C15.4552 3.44792 15.95 4.61979 15.95 6ZM13.1375 3.8125C12.5385 3.1875 11.8094 2.875 10.95 2.875C10.0906 2.875 9.34844 3.1875 8.72344 3.8125C8.12448 4.41146 7.825 5.14062 7.825 6H14.075C14.075 5.14062 13.7625 4.41146 13.1375 3.8125ZM17.825 17.875V7.875H15.95V9.4375C15.95 9.69792 15.8589 9.91927 15.6766 10.1016C15.4943 10.2839 15.2729 10.375 15.0125 10.375C14.7521 10.375 14.5307 10.2839 14.3484 10.1016C14.1661 9.91927 14.075 9.69792 14.075 9.4375V7.875H7.825V9.4375C7.825 9.69792 7.73385 9.91927 7.55156 10.1016C7.36927 10.2839 7.14792 10.375 6.8875 10.375C6.62708 10.375 6.40573 10.2839 6.22344 10.1016C6.04115 9.91927 5.95 9.69792 5.95 9.4375V7.875H4.075V17.875C4.075 18.2135 4.19219 18.5 4.42656 18.7344C4.68698 18.9948 4.98646 19.125 5.325 19.125H16.575C16.9135 19.125 17.2 18.9948 17.4344 18.7344C17.6948 18.5 17.825 18.2135 17.825 17.875Z">
                                            </path>
                                        </svg>
                                    </a>
                                    <!-- ================================== -->
                                    <a class="d-none d-lg-block" href="{{ url('/cart') }}"><div class="d-flex-item"> <svg  width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.27236 19.3721C6.27946 19.3721 5.47455 20.1837 5.47455 21.1849C5.47455 22.1861 6.27946 22.9977 7.27236 22.9977C8.26526 22.9977 9.07017 22.1861 9.07017 21.1849C9.07017 20.1837 8.26526 19.3721 7.27236 19.3721ZM19.5774 19.3722C18.5845 19.3722 17.7796 20.1838 17.7796 21.185C17.7796 22.1862 18.5845 22.9978 19.5774 22.9978C20.5703 22.9978 21.3752 22.1862 21.3752 21.185C21.3752 20.1838 20.5703 19.3722 19.5774 19.3722Z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M1 1.0022H5.44999L6.08938 5.83638H22.9978L21.1882 14.9619C20.9305 16.2613 19.7991 17.1967 18.4853 17.1967H8.31206C6.9311 17.1967 5.76222 16.1657 5.58004 14.7841L3.98096 2.69416H1V1.0022ZM6.31317 7.52835L7.24327 14.5605C7.31441 15.1007 7.77167 15.5047 8.31206 15.5047H18.4853C18.999 15.5047 19.4419 15.1388 19.5428 14.6302C19.5428 14.6302 19.5428 14.6302 19.5428 14.6302L20.9511 7.52835H6.31317Z" fill="currentColor"></path></svg>
                                    Giỏ hàng
                                    </div>
                                        <span class="cart-total">
                                            {{ count(session('cart', [])) }}</span></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- haeader bottom Start -->
            <div class="haeader-bottom-area bg-gren header-sticky">
                <div class="container">
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
                            <div class="logo"><a href="{{URL::to('/')}}"><img src="public/images/logo.webp" alt="Logo"></a>
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
                <div class="row">
                    <div class="col-lg-4">
                        <div class="widget-footer ">
                            <h6 class="title-widget">Thông tin liên hệ</h6>
                            <ul class="footer-list">
                                <li class="clearfix">
                                    <i class='bx bx-map'></i>
                                    <span>CN1: 396 - 398 Nguyễn Kiệm, P. 3, Q. Phú Nhuận, HCM</span>
                                </li>
                                <li class="clearfix">
                                    <i class='bx bx-map'></i>
                                    <span>CN2: 55 Chu Mạnh Trinh, P. Bình Thọ, Q. Thủ Đức, HCM</span>
                                </li>
                                <li class="clearfix">
                                    <i class='bx bx-map'></i>
                                    <span>CN3: 184/41 Nguyễn Xí, Phường 26, Q. Bình Thạnh, HCM</span>
                                </li>
                                <li class="clearfix">
                                    <i class='bx bx-phone'></i>
                                    <span>Tổng đài hỗ trợ: 0906 866 535 (8:30 - 17:30)</span>
                                </li>
                                <li class="clearfix">
                                    <i class='bx bx-mail-send'></i>
                                    <span><a href="mailto:test2000@gmail.com">test2000@gmail.com</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="widget-footer ">
                            <h6 class="title-widget">Liên kết</h6>
                            <ul class="footer-list">
                                <li><a href="index.html">Trang chủ</a></li>
                                <li><a href="vechungtoi.html">Về chúng tôi</a></li>
                                <li><a href="sanpham.html">Sản phẩm</a></li>
                                <li><a href="tintuc.html">Tin tức nổi bật</a></li>
                                <li><a href="tintuc.html">Tin tức nổi bật</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="widget-footer ">
                            <h6 class="title-widget">Hỗ trợ</h6>
                            <ul class="footer-list">
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Chính sách mua hàng</a></li>
                                <li><a href="#">Hỗ trợ mua hàng</a></li>
                                <li><a href="#">Hỗ trợ kỹ thuật</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="widget-footer ">
                            <h6 class="title-widget">Bản đồ</h6>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.14003056735!2d106.67761601524109!3d10.80058536169965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528d77aea3b1d%3A0x9146d5cdf75abe16!2zSGFuZ2NoaW5oaGlldS52biB8IENodXnDqm4gTGFwdG9wIENoxqFpIEdhbWUsIExhcHRvcCBHYW1pbmcgfCBDaMOtbmggSMOjbmcgLSBHacOhIFPhu5Fj!5e0!3m2!1svi!2s!4v1668604526117!5m2!1svi!2s" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                            <p>Copyright &copy; <a href="#">Cửa hàng quần áo</a> 2022. All Right Reserved.</p>
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
        // Bắt thông báo thành công và ẩn nó sau 3 giây
        document.addEventListener("DOMContentLoaded", function() {
            var successAlert = document.querySelector('.alert');

            if (successAlert) {
                setTimeout(function() {
                    successAlert.classList.add('d-none');
                }, 5000); // 4 giây
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
            var sticky = $('#myHeader')
                , scroll = $(window).scrollTop();
        });
        toastr.options = {
            'closeButton': true
            , 'debug': false
            , 'newestOnTop': false
            , 'progressBar': false
            , 'positionClass': 'toast-top-right'
            , 'preventDuplicates': false
            , 'showDuration': '1000'
            , 'hideDuration': '1000'
            , 'timeOut': '5000'
            , 'extendedTimeOut': '1000'
            , 'showEasing': 'swing'
            , 'hideEasing': 'linear'
            , 'showMethod': 'fadeIn'
            , 'hideMethod': 'fadeOut'
        , }

    </script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30
            , hashNavigation: {
                watchState: true
            , }
            , pagination: {
                el: ".swiper-pagination"
                , clickable: true
            , }
            , navigation: {
                nextEl: ".swiper-button-next"
                , prevEl: ".swiper-button-prev"
            , }
        , });
        $('.error').delay(2000).hide(0);
        $('.alert').delay(2000).hide(0);

    </script>

</body>

</html>


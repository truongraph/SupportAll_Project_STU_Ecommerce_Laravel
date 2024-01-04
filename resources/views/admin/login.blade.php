<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>Đăng nhập quản lý bán hàng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Pichforest" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend_area/assets/images/favicon.ico') }}">
    <!-- Bootstrap Css -->
    <link href="{{ asset('backend_area/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend_area/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend_area/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark">


    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">

                                    <div>
                                        <h5><b>HỆ THỐNG QUẢN LÝ BÁN HÀNG</b></h5>
                                        <p class="text-muted">Đăng nhập tài khoản để bắt đầu quản trị</p>
                                    </div>

                                    <div class="pt-2">
                                        <form method="POST" action="/admin/login">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="username" class="fw-semibold">Email hoặc tên tài khoản</label>
                                                <input type="text" class="form-control" id="email" name="email">
                                            </div>

                                            <div class="mb-3">
                                                <label for="userpassword" class="fw-semibold">Mật khẩu</label>
                                                <input type="password" class="form-control" id="password" name="password" >
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-end">
                                                        <button class="btn btn-success w-md waves-effect waves-light" type="submit">Đăng nhập hệ thống</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4 bg-auth h-100 d-none d-lg-block">
                                    {{-- <img src="{{URL::to('backend_area/assets/images/bg.jpg')}}" alt=""> --}}
                                    <div class="bg-overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                    <div class="mt-5 text-center">
                        <p>Đi đến trang đặt hàng <a href="{{URL::to('/')}}" class="fw-semibold text-decoration-underline text-primary"> tại đây </a> </p>
                        <p>© 2023 <b>Hệ thống quản lý bán hàng</b></p>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>


    <!-- /.login-box -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('backend_area/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('backend_area/assets/js/pages/datatables.init.js') }}"></script>
    <!-- dashboard init -->
    <script src="{{ asset('backend_area/assets/js/pages/dashboard.init.js') }}"></script>

    <script src="{{ asset('backend_area/assets/js/app.js') }}"></script>
    <script>
        // Hàm ẩn thông báo sau một khoảng thời gian
        function hideAlert() {
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 4000);
            });
        }

        // Gọi hàm ẩn thông báo khi trang được tải
        window.onload = function() {
            hideAlert();
        };
    </script>
</body>
</html>


<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Quản lý bán hàng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Pichforest" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend_area/assets/images/favicon.ico') }}">
    <!-- DataTables -->
    <link href="{{ asset('backend_area/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_area/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- Select datatable -->
    <link href="{{ asset('backend_area/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend_area/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{ asset('backend_area/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable -->
    <link href="{{ asset('backend_area/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('backend_area/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend_area/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend_area/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- Thư viện Bootstrap Datepicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet">


</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a class="logo logo-dark">
                            <span class="logo-sm">
                                QT
                            </span>
                            <span class="logo-lg">
                                HỆ THỐNG QUẢN TRỊ
                            </span>
                        </a>
                        <a class="logo logo-light">
                            <span class="logo-sm">
                                QT
                            </span>
                            <span class="logo-lg">
                                HỆ THỐNG QUẢN TRỊ
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-16 vertinav-toggle header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    <button type="button"
                        class="btn btn-sm px-3 font-size-16 horinav-toggle header-item waves-effect waves-light"
                        data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="mdi mdi-fullscreen"></i>
                        </button>
                    </div>


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{URL::to('backend_area/assets/images/avt.png')}}" alt="Header Avatar">
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header uppercase">@if(Auth::check())
                                Xin chào, {{ Auth::user()->name }}
                                @endif</h6>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit"><i
                                        class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i> <span
                                        class="align-middle" key="t-logout">Đăng xuất</span></button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" key="t-menu">
                            Tổng quan
                        </li>
                        <li>
                            <a href="{{URL::to('/')}}" class="waves-effect">
                                <i class='bx bx-store'></i>
                                <span key="t-ui-elements">Website đặt hàng</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/dashboard*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}"
                                class="waves-effect {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                                <i class='bx bx-desktop'></i>
                                <span key="t-ui-elements">Bảng điều khiển</span>
                            </a>
                        </li>
                        <li class="menu-title" key="t-menu">
                            Thông tin quản trị
                        </li>
                        <li class="{{ Request::is('admin/accounts*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.accounts.index') }}"
                                class="waves-effect {{ Request::is('admin/accounts*') ? 'active' : '' }}">
                                <i class='bx bx-user'></i>
                                <span key="t-ui-elements">Tài khoản</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/customers*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.customers.index') }}"
                                class="waves-effect {{ Request::is('admin/customers*') ? 'active' : '' }}">
                                <i class='bx bx-layer'></i>
                                <span key="t-ui-elements">Khách hàng</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/categories*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.categories.index') }}"
                                class="waves-effect {{ Request::is('admin/categories*') ? 'active' : '' }}">
                                <i class='bx bx-archive'></i>
                                <span key="t-ui-elements">Danh mục sản phẩm</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/colors*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.colors.index') }}"
                                class="waves-effect {{ Request::is('admin/colors*') ? 'active' : '' }}">
                                <i class='bx bx-palette'></i>
                                <span key="t-ui-elements">Màu sắc</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/sizes*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.sizes.index') }}"
                                class="waves-effect {{ Request::is('admin/sizes*') ? 'active' : '' }}">
                                <i class='bx bx-ruler'></i>
                                <span key="t-ui-elements">Kích thước</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/products*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.products.index') }}"
                                class="waves-effect {{ Request::is('admin/products*') ? 'active' : '' }}">
                                <i class='bx bx-package'></i>
                                <span key="t-ui-elements">Sản phẩm</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/orders*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.orders.index') }}"
                             class="waves-effect {{ Request::is('admin/orders*') ? 'active' : '' }}">
                                <i class='bx bx-archive-in'></i>
                                <span key="t-ui-elements">Đơn hàng</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/discounts*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.discounts.index') }}"
                                class="waves-effect {{ Request::is('admin/discounts*') ? 'active' : '' }}">
                                <i class='bx bx-certification'></i>
                                <span key="t-ui-elements">Mã giảm giá</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/banners*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.banners.index') }}"
                             class="waves-effect {{ Request::is('admin/banners*') ? 'active' : '' }}">
                                <i class='bx bx-collection'></i>
                                <span key="t-ui-elements">Banner</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <!-- End Page-content -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            © 2023 Hệ thống quản lý bán hàng.
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </div>
    <script>
        // Bắt thông báo thành công và ẩn nó sau 3 giây
        document.addEventListener("DOMContentLoaded", function() {
            var successAlert = document.querySelector('.alert');

            if (successAlert) {
                setTimeout(function() {
                    successAlert.classList.add('d-none');
                }, 4000); // 4 giây
            }
        });
    </script>

    <!-- JAVASCRIPT -->

    <script src="{{ asset('backend_area/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('backend_area/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('backend_area/assets/libs/select2/js/select2.min.js') }}"></script>

    <!-- Buttons examples -->
    <script src="{{ asset('backend_area/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('backend_area/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('backend_area/assets/libs/datatables.net-keyTable/js/dataTables.keyTable.min.html') }}">
    </script>
    <script src="{{ asset('backend_area/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <!-- apexcharts -->
    <script src="{{ asset('backend_area/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('backend_area/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('backend_area/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('backend_area/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset('backend_area/assets/js/pages/sweet-alerts.init.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('backend_area/assets/js/pages/datatables.init.js') }}"></script>
    <!-- dashboard init -->
    <script src="{{ asset('backend_area/assets/js/pages/dashboard.init.js') }}"></script>


    <script src="{{ asset('backend_area/assets/js/app.js') }}"></script>
    <!-- Thêm thư viện jQuery và Bootstrap JS -->

    <!-- Thư viện Bootstrap Datepicker -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Thêm thư viện CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    <script>
        ClassicEditor
        .create(document.querySelector('.ckeditor'), {
            height: 400 // Thiết lập chiều cao (vd: 400px)
        })
        .catch(error => {
            console.error(error);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('.pickdate', {
                enableTime: true,
                dateFormat: "d/m/Y H:i",
            });
        });
    </script>
    <script>
        $(document).ready(function(){
        $('.select2').select2();
    });
    </script>
    <script>
        $(document).ready(function() {
            $('#Tabledatatable').DataTable({
                "responsive": false,
                "scrollX": true,
                "language": {
                    "sProcessing": "Đang xử lý..."
                    , "sLengthMenu": "Hiển thị _MENU_ danh sách"
                    , "sZeroRecords": "Không tìm thấy dữ liệu"
                    , "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ danh sách"
                    , "sInfoEmpty": "Hiển thị 0 đến 0 của 0 h"
                    , "sInfoFiltered": "(được lọc từ _MAX_ tổng số danh sách)"
                    , "sInfoPostFix": ""
                    , "sSearch": "Tìm kiếm:"
                    , "sUrl": ""
                    , "oPaginate": {
                        "sFirst": "Trang đầu"
                        , "sPrevious": "Trước"
                        , "sNext": "Tiếp"
                        , "sLast": "Trang cuối"
                    }
                }
            });
        });

    </script>
</body>

</html>

@extends('layouts.app')

@section('content')
    @if (session()->has('account_id'))
        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Tài khoản của tôi</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->
        <!-- main-content-wrap start -->
        <div class="main-content-wrap section-ptb my-account-page">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="account-dashboard">
                            <div class="dashboard-upper-info">
                                <h4>Quản lý tài khoản</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-3">
                                    <!-- Nav tabs -->
                                    <ul role="tablist" class="nav flex-column dashboard-list">
                                        <li><a href="#dashboard" data-bs-toggle="tab" class="nav-link active"><i
                                                    class='bx bxs-user-circle'></i> Thông tin tài khoản</a></li>
                                        <li> <a href="#orders" data-bs-toggle="tab" class="nav-link"><i
                                                    class='bx bxs-package'></i> Danh sách đơn hàng</a></li>
                                        @if (session()->has('account_id'))
                                            <li><a href="{{ route('change.password.view') }}" class="nav-link"><i
                                                        class='bx bxs-key'></i> Thay đổi mật khẩu</a></li>
                                        @endif
                                        <li><a href="{{ route('logout') }}" class="nav-link"><i
                                                    class='bx bxs-log-in-circle'></i> Đăng xuất tài khoản</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-12 col-lg-9">
                                    <!-- Tab panes -->
                                    <div class="tab-content dashboard-content">
                                        <div class="tab-pane fade @if (!session()->has('activeTab') || session('activeTab') === 'dashboard') show active @endif"
                                            id="dashboard">
                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif
                                            @if(session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                            @endif
                                            <h3>Thông tin tài khoản</h3>
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <p><strong>Tên tài khoản: </strong>{{ $account->name_account }}</p>
                                                    <p><strong>Email: </strong>{{ $customer->email_customer }}</p>
                                                    <p><strong>Ngày lập tài khoản:
                                                        </strong>{{ $account->created_at->format('d/m/Y H:i:s') }}</p>
                                                </div>
                                                <!-- Form và thông báo lỗi -->
                                                <form action="{{ route('update.customer.info') }}" method="post">
                                                    @csrf
                                                    <div class="col-lg-12 row">
                                                        <!-- Các trường nhập thông tin -->
                                                        <div class="login-input-box col-md-3">
                                                            <div class="col_full">
                                                                <label for="name">Họ và tên</label>
                                                                <input type="text" name="name"
                                                                    value="{{ $customer->name_customer }}"
                                                                    class="form-control">
                                                            </div>
                                                            @error('name')
                                                                <p class="alert alert-danger"> {{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="login-input-box col-md-3">
                                                            <div class="col_full">
                                                                <label for="phone">Số điện thoại</label>
                                                                <input type="number" name="phone"
                                                                    value="{{ $customer->phone_customer }}"
                                                                    class="form-control">
                                                            </div>
                                                            @error('phone')
                                                                <p class="alert alert-danger"> {{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="login-input-box col-md-6">
                                                            <div class="col_full">
                                                                <label for="address">Địa chỉ</label>
                                                                <input type="text" name="address"
                                                                    value="{{ $customer->address_customer }}"
                                                                    class="form-control">
                                                            </div>

                                                        </div>
                                                        <div class="login-input-box col-md-6">
                                                            <button class="continue-btn" type="submit">Cập nhật thông
                                                                tin</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade @if (session('activeTab') === 'orders') show active @endif"
                                            id="orders">
                                            <h3>Đơn hàng của bạn</h3>
                                            <div class="table-responsive">
                                                @if ($orders->isNotEmpty())
                                                    <table
                                                        class="table table-responsive table-bordered text-left my-orders-table">
                                                        <thead>
                                                            <tr class="first last">
                                                                <th class=" last">Mã đơn</th>
                                                                <th class="text-left last">Ngày đặt</th>
                                                                <th class="text-right last">Giá trị đơn hàng</th>
                                                                <th class="text-center last"><span class="nobr">Trạng
                                                                        thái</span></th>
                                                                <th class="text-center last">Thao tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($orders as $order)
                                                                <tr>
                                                                    <td class="last"><a
                                                                            href="{{ route('order.detail', ['orderId' => $order->id]) }}"
                                                                            style="color: #1d6cd9;font-weight: 600;">#{{ $order->code_order }}</a>
                                                                    </td>
                                                                    <td class="text-left last">
                                                                        {{ \Carbon\Carbon::parse($order->date_order)->format('d/m/Y H:i:s') }}
                                                                    </td>
                                                                    <td class="text-right last" width="150px"><span
                                                                            class="price-2 font-bold">{{ number_format($order->total_order) }}
                                                                            đ</span></td>
                                                                    <td class="text-center last">
                                                                        <span
                                                                            class="badge @if ($order->status_order == 1) pending @elseif($order->status_order == 0) cancelled @elseif($order->status_order == 2) confirmed @elseif($order->status_order == 3) delivering @elseif($order->status_order == 4) delivered  @elseif($order->status_order == 5) warning @endif">
                                                                            @if ($order->status_order == 1)
                                                                                Chờ xác nhận
                                                                            @elseif($order->status_order == 0)
                                                                                Đã huỷ
                                                                            @elseif($order->status_order == 2)
                                                                                Đã xác nhận
                                                                            @elseif($order->status_order == 3)
                                                                                Đang giao hàng
                                                                            @elseif($order->status_order == 4)
                                                                                Giao thành công
                                                                            @elseif($order->status_order == 5)
                                                                                Hoàn trả
                                                                            @endif
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center last">
                                                                        @if ($order->status_order === 1)
                                                                            <a href="#" class="btn-reorder" data-id="{{ $order->id }}">
                                                                                <i class='bx bx-x-circle'></i> Hủy đơn hàng
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <p>Không có đơn hàng nào.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Redirect nếu chưa đăng nhập -->
        <script>
            window.location.href = "{{ route('login') }}";
        </script>
    @endif
    <!-- Điều hướng hoặc nội dung khác -->

    <script>
        $(document).ready(function() {
            // Lưu trạng thái tab được chọn
            let activeTab = "{{ session('activeTab') }}";
            if (activeTab) {
                $('.nav-link').removeClass('active');
                $(`.nav-link[href="#${activeTab}"]`).addClass('active');

                // Scroll đến vị trí trang trước khi reload
                let scrollPosition = localStorage.getItem('scrollPosition');
                if (scrollPosition) {
                    $(window).scrollTop(scrollPosition);
                }
            }

            // Lưu trạng thái cuộn trang
            $(window).on('scroll', function() {
                localStorage.setItem('scrollPosition', $(window).scrollTop());
            });
        });
        //Hủy đơn
        const cancelOrderLinks = document.querySelectorAll('.btn-reorder');

        cancelOrderLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const orderID = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Xác nhận hủy đơn hàng',
                    text: 'Bạn có chắc muốn hủy đơn hàng này không?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#34c3af',
                    cancelButtonColor: '#f46a6a',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Huỷ bỏ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Thực hiện hủy đơn hàng
                        window.location.href = `/cancel-order/${orderID}`;
                    }
                });
            });
        });
    </script>
@endsection

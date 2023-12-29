@extends('layouts.admin_layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between card flex-sm-row border-0">
                <h4 class="mb-sm-0 font-size-16 fw-bold">CHỈNH SỬA MÃ GIẢM</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách mã giảm</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa mã giảm</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.discounts.update', $discount->id) }}">
                            @csrf
                            @method('PUT')
                            <div class=" row" bis_skin_checked="1">
                                <div class="col-md-6" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="code" class="form-label">Tên mã giảm</label>
                                        <input value="{{ $discount->code }}" type="text" class="form-control"
                                            id="code" name="code">
                                    </div>
                                </div>
                                <div class="col-md-6" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="discount" class="form-label">Số tiền giảm</label>
                                        <input value="{{ number_format($discount->discount, 0, '', ',') }}" type="text"
                                            oninput="formatNumber(this)" class="form-control" id="discount"
                                            name="discount">
                                    </div>
                                </div>
                                <div class="col-md-6" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="limit_number" class="form-label">Giới hạn số lần</label>
                                        <input value="{{ number_format($discount->limit_number, 0, '', ',') }}"
                                            type="text" oninput="formatNumber(this)" class="form-control"
                                            id="limit_number" name="limit_number">
                                    </div>
                                </div>
                                <div class="col-md-6" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="number_used" class="form-label">Đã sử dụng</label>
                                        <input value="{{ number_format($discount->number_used, 0, '', ',') }}"
                                            type="text" oninput="formatNumber(this)" class="form-control"
                                            id="number_used" name="number_used" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="expiration_date" class="form-label">Ngày hết hạn</label>
                                        <input
                                            value="{{ \Carbon\Carbon::parse($discount->expiration_date)->format('d/m/Y H:i') }}"
                                            type="text" class="form-control pickdate" id="expiration_date"
                                            name="expiration_date">
                                    </div>
                                </div>
                                <div class="col-md-6" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="payment_limit" class="form-label">Thanh toán tối thiểu</label>
                                        <input value="{{ number_format($discount->payment_limit, 0, '', ',') }}"
                                            type="text" oninput="formatNumber(this)" class="form-control"
                                            id="payment_limit" name="payment_limit">
                                    </div>
                                </div>
                                <div bis_skin_checked="1" class="text-right">
                                    <button class="btn btn-success" type="submit"><i class="bx bx-save"></i> Cập
                                        nhật</button>
                                    <a href="#" class="btn btn-danger delete-discount" style="float: right"
                                        data-id="{{ $discount->id }}"><i class="bx bx-trash"></i> Xoá mã giảm</a>
                                    <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary"><i
                                            class="bx bx-x-circle"></i> Huỷ bỏ</a>
                                </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        const deleteLinks = document.querySelectorAll('.delete-discount');
        deleteLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const discountID = this.getAttribute('data-id');
                Swal.fire({
                    title: "Thông báo",
                    text: "Bạn có chắc muốn xoá mã giảm này không?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#34c3af",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Đồng ý xoá",
                    cancelButtonText: "Huỷ bỏ"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/discounts/delete/${discountID}`;
                    }
                });
            });
        });
    </script>
    <script>
        function formatNumber(input) {
            // Xóa các ký tự không phải số khỏi giá trị nhập vào
            let value = input.value.replace(/\D/g, '');

            // Định dạng số có dấu phân cách hàng nghìn, nếu có giá trị thì mới định dạng
            if (value !== '') {
                value = new Intl.NumberFormat('en-US').format(value);
            }

            // Gán giá trị đã định dạng trở lại vào input
            input.value = value;
        }
    </script>
@endsection

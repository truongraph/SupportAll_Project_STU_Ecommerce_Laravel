@extends('layouts.admin_layout')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Tiêu đề -->
        <div class="page-title-box d-sm-flex align-items-center justify-content-between card flex-sm-row border-0">
            <h4 class="mb-sm-0 font-size-16 fw-bold">DANH MỤC BANNER</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh mục banner</li>
                </ol>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <!-- Form thêm mới màu sắc -->
    <div class="col-xl-4">
        <!-- Thông báo -->
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
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row" bis_skin_checked="1">
                        <div class="col-md-12" bis_skin_checked="1">
                            <div class="mb-3" bis_skin_checked="1">
                                <label for="name" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event)" required>
                               <div style="position: relative">
                                <img id="preview_image" src="" alt="Preview Image" style="width: 100%; height: 300px; display: none;margin-top:10px">
                                <button style="display: none;position: absolute;top:5px;right:5px" class="btn btn-outline-danger" type="button" id="deletePreviewBtn" onclick="clearPreview()"><i class="bx bx-trash"></i></button>
                               </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-12" bis_skin_checked="1">
                            <div class="mb-3" bis_skin_checked="1">
                                <label for="link" class="form-label">Liên kết</label>
                                <input type="text" class="form-control" id="link" name="link">
                            </div>
                        </div> --}}

                    </div>
                    <div class="row" bis_skin_checked="1">
                        <div class="col-md-12" bis_skin_checked="1">
                            <div class="mb-3" bis_skin_checked="1">
                                <label for="parent" class="form-label">Loại banner</label>
                                <select class="form-control select2" id="banner_type" name="banner_type">
                                    <option value="main">Banner chính</option>
                                    <option value="secon1">Banner phụ 1</option>
                                    <option value="secon2">Banner phụ 2</option>
                                    <option value="secon3">Banner phụ 3</option>
                                    <option value="secon4">Banner phụ 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit"><i class="bx bx-save"></i> Lưu banner</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Danh sách màu sắc -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <form class="border-bottom mb-3" action="{{ route('admin.banners.index') }}" method="GET">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <select class="form-select select2" id="type_filter" name="type_filter">
                                <option value="">Chọn loại</option>
                                <option value="main" {{ request('type_filter') == 'main' ? 'selected' : '' }}>Banner chính</option>
                                <option value="secon1" {{ request('type_filter') == 'secon1' ? 'selected' : '' }}>Banner phụ 1</option>
                                <option value="secon2" {{ request('type_filter') == 'secon2' ? 'selected' : '' }}>Banner phụ 2</option>
                                <option value="secon3" {{ request('type_filter') == 'secon3' ? 'selected' : '' }}>Banner phụ 3</option>
                                <option value="secon4" {{ request('type_filter') == 'secon4' ? 'selected' : '' }}>Banner phụ 4</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select select2" id="status_filter" name="status_filter">
                                <option value="">Chọn trạng thái</option>
                                <option value="active" {{ request('status_filter') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ request('status_filter') == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                            </select>
                        </div>
                        <div class="col-md-2" style ="margin-right: -75px">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-filter-alt"></i> Lọc</button>

                        </div>
                        <div class="col-md-2">

                            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary"><i class="bx bx-reset"></i> Reset</a>
                        </div>
                    </div>

                </form>
                <table id="Tabledatatable" class="table table-bordered dt-responsive nowrap w-100">
                    <!-- Tiêu đề bảng -->
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Hình ảnh</th>
                            <th>Loại banner</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th style="width: 90px">Chức năng</th>
                        </tr>
                    </thead>
                    <!-- Dữ liệu bảng -->
                    <tbody>
                        @php
                        $count = 1; // Khởi tạo biến đếm
                        @endphp
                        @foreach($banners as $banner)
                        <tr>
                            <td class="text-center">{{ $count++ }}</td>
                            <td>
                                @php
                                // Xác định đường dẫn hình ảnh dựa trên loại banner
                                $imagePath = '';
                                switch ($banner->type) {
                                case 'main':
                                $imagePath = 'img/banners/main/' . $banner->image;
                                $bannerType = 'Banner chính';
                                break;
                                case 'secon1':
                                $imagePath = 'img/banners/secon1/' . $banner->image;
                                $bannerType = 'Banner phụ 1';
                                break;
                                case 'secon2':
                                $imagePath = 'img/banners/secon2/' . $banner->image;
                                $bannerType = 'Banner phụ 2';
                                break;
                                case 'secon3':
                                $imagePath = 'img/banners/secon3/' . $banner->image;
                                $bannerType = 'Banner phụ 3';
                                break;
                                case 'secon4':
                                $imagePath = 'img/banners/secon4/' . $banner->image;
                                $bannerType = 'Banner phụ 4';
                                break;
                                default:
                                $imagePath = ''; // Nếu không khớp với bất kỳ loại nào
                                $bannerType = 'Không xác định';
                                break;
                                }
                                @endphp
                                @if ($imagePath)
                                <img style="width: 100px" src="{{ asset($imagePath) }}" alt="Banner Image">
                                @endif
                            </td>
                            <td>{{ $bannerType }}</td>
                            <td>{{ \Carbon\Carbon::parse($banner->created_at)->format('d/m/Y H:i:s') }}</td>
                            <td>@if($banner->status == 1)
                                <small class="badge badge-soft-success">Hoạt động</small>
                                @elseif($banner->status == 0)
                                <small class="badge badge-soft-danger">Ngừng hoạt động</small>
                                @else
                                Trạng thái không xác định
                                @endif</td>
                            <td>
                                <div style="display:flex; gap:10px">
                                    <a href="{{ route('admin.banners.activate', $banner->id) }}" class="btn fw-bold {{ ($banner->status == 1) ? 'btn-outline-danger' : 'btn-outline-success' }}"><i class="bx {{ ($banner->status == 1) ? 'bx-x' : 'bx-check' }}"></i> {{ ($banner->status == 1) ? 'Ngừng hoạt động' : 'Hoạt động' }}</a>
                                    <a href="#" class="btn btn-danger delete-banner" data-id="{{ $banner->id }}"><i class="bx bx-trash"></i> Xoá</a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function previewImage(event) {
        const input = event.target;
        const previewImage = document.getElementById('preview_image');
        const deletePreviewBtn = document.getElementById('deletePreviewBtn');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                deletePreviewBtn.style.display = 'block'; // Hiển thị nút xoá
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewImage.style.display = 'none';
            deletePreviewBtn.style.display = 'none'; // Ẩn nút xoá nếu không có hình
        }
    }

    function clearPreview() {
        const previewImage = document.getElementById('preview_image');
        const inputImage = document.getElementById('image');
        const deletePreviewBtn = document.getElementById('deletePreviewBtn');

        previewImage.src = '';
        previewImage.style.display = 'none';
        deletePreviewBtn.style.display = 'none';
        inputImage.value = ''; // Xóa giá trị của input file để reset hình ảnh đã chọn
    }
</script>
<script>
    // Xác nhận xoá
    const deleteLinks = document.querySelectorAll('.delete-banner');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const bannerId = this.getAttribute('data-id');
            Swal.fire({
                title: "Thông báo"
                , text: "Bạn có chắc muốn xoá banner này không?"
                , icon: "warning"
                , showCancelButton: true
                , confirmButtonColor: "#34c3af"
                , cancelButtonColor: "#f46a6a"
                , confirmButtonText: "Đồng ý xoá"
                , cancelButtonText: "Huỷ bỏ"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/banners/delete/${bannerId}`;
                }
            });
        });
    });

</script>
@endsection


<!-- create.blade.php -->
@extends('layouts.admin_layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between card flex-sm-row border-0">
                <h4 class="mb-sm-0 font-size-16 fw-bold">CHỈNH SỬA SẢN PHẨM</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách sản phẩm</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa sản phẩm</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        {{-- @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
        {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endforeach
    @endif --}}
        <form method="post" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data"
            onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            <div bis_skin_checked="1" class="mb-3">
                <button class="btn btn-success" type="submit"><i class="bx bx-save"></i> Lưu sản
                    phẩm</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"><i class="bx bx-x-circle"></i> Huỷ
                    bỏ</a>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="name_product" class="form-label">Tên sản phẩm</label>
                                        <input type="text" class="form-control" id="name_product" name="name_product"
                                            value="{{ $product->name_product ?? old('name_product') }}">
                                    </div>
                                    @error('name_product')
                                        <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">Mã sản phẩm</label>
                                        <a style="float: right;font-weight:600;color:rgb(0, 116, 194);cursor: pointer;"
                                            onclick="generateSKU()">Tự động tạo mã</a>
                                        <input type="text" class="form-control" id="sku" name="sku"
                                            value="{{ $product->sku ?? old('sku') }}">
                                    </div>
                                    @error('sku')
                                        <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="link_product" class="form-label">Liên kết đường dẫn</label>
                                        <input type="text" class="form-control" id="link_product"
                                            value="{{ $product->link_product ?? old('link_product') }}" name="link_product"
                                            readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row" bis_skin_checked="1">
                                <div class="col-md-12" bis_skin_checked="1">
                                    <label for="variant" class="form-label">Các thuộc tính</label>
                                    <div class="mb-3">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <select class="form-control select2" id="colorSelect">
                                                    <option value="" disabled selected hidden>Chọn màu</option>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->id }}">{{ $color->desc_color }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control select2" id="sizeSelect">
                                                    <option value="" disabled selected hidden>Chọn kích thước</option>
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size->id }}">{{ $size->desc_size }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-flex" style="gap: 20px">
                                                <input class="form-control" type="number" id="quantity"
                                                    placeholder="Số lượng">
                                                <a class="btn btn-primary fw-bold" onclick="addVariant()">Thêm</a>
                                            </div>
                                        </div>
                                        <div id="variants">
                                            @foreach ($product->variants as $variant)
                                                <div class="variant-row" data-variant-id="{{ $variant->id }}">
                                                    <div class="color-name">{{ $variant->color->desc_color }}</div>
                                                    <div class="size-name">{{ $variant->size->desc_size }}</div>
                                                    <input class="quantity-input" type="text"
                                                        value="{{ $variant->quantity }}" readonly>
                                                    <a class="edit-quantity">Chỉnh sửa</a>
                                                    <a class="remove-variant">Xóa</a>
                                                    <a class="confirm-edit" style="display: none;">Xác nhận</a>
                                                    <a class="cancel-edit" style="display: none;">Hủy bỏ</a>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div id="variantsInput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row" bis_skin_checked="1">
                                {{-- <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="sortdesc_product" class="form-label">Mô tả ngắn</label>
                                    <textarea class="form-control" id="sortdesc_product" name="sortdesc_product"
                                        rows="8">{{ $product->sortdesc_product ?? old('sortdesc_product') }}</textarea>
                                </div>
                            </div> --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="desc_product" class="form-label">Mô tả sản phẩm</label>
                                        <textarea class="form-control ckeditor" id="desc_product" name="desc_product">{{ $product->desc_product ?? old('desc_product') }}</textarea>
                                    </div>
                                    @error('desc_product')
                                        <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" bis_skin_checked="1">
                                <div class="col-md-12" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="category" class="form-label">Danh mục sản phẩm</label>
                                        <select class="form-control select2" name="id_category" id="category">
                                            <option value="" disabled hidden>Chọn danh mục</option>
                                            @foreach ($categoriesTree as $category)
                                                @if ($category->parent_id)
                                                    @continue
                                                @endif
                                                <option value="{{ $category->id }}"
                                                    {{ $product->id_category == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name_category }}
                                                </option>
                                                @if ($category->children)
                                                    @foreach ($category->children as $child)
                                                        <option value="{{ $child->id }}"
                                                            {{ $product->id_category == $child->id ? 'selected' : '' }}>
                                                            - {{ $child->name_category }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>

                                    </div>
                                    @error('id_category')
                                        <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price_product" class="form-label">Giá bán</label>
                                        <input type="text"
                                            value="{{ number_format($product->price_product, 0, ',', ',') ?? old('price_product') }}"
                                            oninput="formatNumber(this); calculateDiscount();" class="form-control"
                                            id="price_product" name="price_product">
                                    </div>
                                    @error('price_product')
                                        <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="discount_percent" class="form-label">% Giảm</label>
                                        <input type="text" value="{{ old('discount_percent') }}"
                                            oninput="formatNumber(this); calculateDiscount();" class="form-control"
                                            id="discount_percent" name="discount_percent">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="sellprice_product" class="form-label">Giá giảm</label>
                                        <input type="text"
                                            value="{{ number_format($product->sellprice_product, 0, ',', ',') ?? old('sellprice_product') }}"
                                            oninput="formatNumber(this); calculateSellPrice();" class="form-control"
                                            id="sellprice_product" name="sellprice_product">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row" bis_skin_checked="1">
                                <div class="col-md-12" bis_skin_checked="1">
                                    <div class="mb-3">
                                        <label for="desc_product" class="form-label">Hình đại diện sản phẩm</label>
                                        <div id="imageContainer">
                                            <button class="remove-add-avt" type="button" onclick="removeImageAvt()"
                                                id="removeBtn"
                                                style="{{ $product->avt_product ? 'display:block;' : 'display:none;' }}">Xoá</button>
                                            <img class="avt-img"
                                                src="{{ $product->avt_product ? asset('img/products/' . $product->id . '/' . $product->avt_product) : asset('backend_area/assets/images/empty.jpg') }}"
                                                id="preview">
                                            <button class="button-add-avt" id="chooseBtn" type="button"
                                                onclick="document.getElementById('avt_product').click();"
                                                style="{{ $product->avt_product ? 'display:none;' : 'display:block;' }}"></button>
                                            <input type="file" class="form-control" id="avt_product"
                                                name="avt_product" onchange="previewImage(event)" accept="image/*"
                                                style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row" bis_skin_checked="1">
                                <div class="col-md-12" bis_skin_checked="1">
                                    <div class="mb-3" id="multiImageWrapper">
                                        <label for="image_product" class="form-label">Album ảnh sản phẩm</label>
                                        <div id="multiImageContainer">
                                            <div class="choose-multi-img">
                                                <label for="image_product">Nhấn để tải ảnh lên</label>
                                                <input type="file" class="form-control" id="image_product"
                                                    name="image_product[]"
                                                    onchange="previewMultipleImages(event, 'image_product', 'imagePreview')"
                                                    accept="image/*" multiple>
                                            </div>
                                            <div id="imagePreview">
                                                @php
                                                    $skipFirst = true;
                                                @endphp
                                                @foreach (explode('#', $product->image_product) as $imageName)
                                                    @if ($skipFirst)
                                                        @php
                                                            $skipFirst = false;
                                                            continue; // Bỏ qua ảnh đầu tiên
                                                        @endphp
                                                    @endif

                                                    @if ($imageName)
                                                        <div class="imgmulti">
                                                            <img src="/img/products/{{ $product->id }}/{{ $imageName }}"
                                                                alt="{{ $imageName }}">
                                                            <button
                                                                onclick="removeImage(this, '{{ $imageName }}')">Xoá</button>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- HÀM RANDOM MÃ SẢN PHẨM --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <script>
        function generateSKU() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const length = 8; // Độ dài của mã sản phẩm

            let sku = '';
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                sku += characters.charAt(randomIndex);
            }

            // Đặt giá trị mã sản phẩm vào input
            document.getElementById('sku').value = sku;
        }
    </script>
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- HÀM LOẠI BỎ CÁC KÝ TỰ CHO LINK PRODUCT --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <script>
        $(document).ready(function() {
            $('#name_product').on('input', function() {
                var nameCategory = $(this).val();
                var linkCategory = nameCategory
                    .toLowerCase()
                    .normalize("NFD") // Sử dụng Unicode normalization để loại bỏ dấu
                    .replace(/[\u0300-\u036f]/g, "") // Loại bỏ các ký tự diacritic
                    .replace(/[^\w\s]/gi, '-') // Thay thế các ký tự không phải chữ cái hoặc số bằng dấu '-'
                    .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu '-'
                    .replace(/-+/g, '-') // Loại bỏ các dấu '-' liên tiếp
                    .replace(/^-|-$/g, ''); // Loại bỏ dấu '-' ở đầu và cuối chuỗi
                $('#link_product').val(linkCategory);
            });
        });
    </script>
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- FORMAT SỐ VÀ TÍNH % GIẢM GIÁ --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <script>
        function formatNumber(input) {
            let value = input.value.replace(/\D/g, '');
            if (value !== '') {
                value = new Intl.NumberFormat('en-US').format(value);
            }
            input.value = value;
        }

        function calculateDiscount() {
            const priceInput = document.getElementById('price_product');
            const discountInput = document.getElementById('discount_percent');
            const sellPriceInput = document.getElementById('sellprice_product');

            let price = parseFloat(priceInput.value.replace(/,/g, ''));
            let discountPercent = parseFloat(discountInput.value.replace(/,/g, ''));

            // Kiểm tra nếu discountPercent lớn hơn 100 hoặc nhỏ hơn 0, hoặc không phải là một số
            if (isNaN(discountPercent) || discountPercent > 100 || discountPercent < 0) {
                $.toast({
                    heading: 'Cảnh báo',
                    text: 'Vui lòng nhập giá trị từ 0 đến 100',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
                discountInput.value = ''; // Xóa giá trị nhập nếu không hợp lệ
                sellPriceInput.value = '';
                return;
            }

            if (!isNaN(price) && !isNaN(discountPercent) && price !== 0) {
                let sellPrice = price - (price * discountPercent / 100);
                sellPriceInput.value = sellPrice.toLocaleString('en-US');
            }
        }

        function calculateSellPrice() {
            const priceInput = document.getElementById('price_product');
            const discountInput = document.getElementById('discount_percent');
            const sellPriceInput = document.getElementById('sellprice_product');

            let price = parseFloat(priceInput.value.replace(/,/g, ''));
            let sellPrice = parseFloat(sellPriceInput.value.replace(/,/g, ''));

            if (!isNaN(price) && !isNaN(sellPrice) && price !== 0) {
                let discountPercent = ((price - sellPrice) / price) * 100;

                if (sellPrice !== 0) {
                    discountInput.value = Math.round(discountPercent);
                } else {
                    discountInput.value = ''; // Nếu giá giảm là 0, không hiển thị % giảm
                }
            }
        }

        // Khi trang tải xong, tính toán giá giảm tự động
        document.addEventListener('DOMContentLoaded', function() {
            calculateDiscount();
            calculateSellPrice(); // Tính toán và hiển thị % giảm khi trang tải xong
        });
    </script>
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- HÀM DÀNH CHO ẢNH ĐẠI DIỆN --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('preview');
            const removeBtn = document.getElementById('removeBtn');
            const chooseBtn = document.getElementById('chooseBtn');
            const imageWrapper = document.getElementById('imageWrapper');

            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
                removeBtn.style.display = 'block';
                chooseBtn.style.display = 'none';
                imageWrapper.style.paddingTop = '0'; // Ẩn khoảng trắng dư thừa khi hiển thị hình ảnh
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function removeImageAvt() {
            const preview = document.getElementById('preview');
            const removeBtn = document.getElementById('removeBtn');
            const fileInput = document.getElementById('avt_product');
            const imageContainer = document.getElementById('imageContainer');
            const imageWrapper = document.getElementById('imageWrapper');
            const chooseBtn = document.getElementById('chooseBtn');

            // Xoá ảnh đại diện và hiển thị ảnh mặc định
            preview.src = '{{ asset('backend_area/assets/images/empty.jpg') }}';
            preview.style.display = 'block';
            removeBtn.style.display = 'none';
            fileInput.value = ''; // Xóa giá trị đã chọn trong input file
            imageContainer.style.display = 'block';
            chooseBtn.style.display = 'block';
            imageWrapper.style.paddingTop = '10px'; // Hiển thị khoảng trắng dư thừa khi không có hình
        }
    </script>


    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- HÀM DÀNH CHO ALBUM ẢNH --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <script>
        function removeImage(element, imageName) {
            // Xóa hiển thị hình ảnh
            element.parentElement.remove();

            // Tạo một input ẩn để đánh dấu hình ảnh cần xóa khi lưu form
            const removeImageInput = document.createElement('input');
            removeImageInput.type = 'hidden';
            removeImageInput.name = 'removed_images[]';
            removeImageInput.value = imageName;
            document.getElementById('multiImageWrapper').appendChild(removeImageInput);
        }

        function previewMultipleImages(event, inputId, previewId) {
            const files = event.target.files;
            const imagePreview = document.getElementById(previewId);

            if (files && files.length > 8) {
                $.toast({
                    heading: 'Cảnh báo',
                    text: 'Chỉ được chọn tối đa 8 ảnh',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
                document.getElementById(inputId).value = '';
                return;
            }

            if (files) {
                const existingImages = imagePreview.querySelectorAll('.imgmulti').length;
                const remainingSlots = 8 - existingImages;

                if (files.length > remainingSlots) {
                    $.toast({
                        heading: 'Cảnh báo',
                        text: `Bạn chỉ còn thêm được ${remainingSlots} hình ảnh`,
                        hideAfter: 3000,
                        icon: 'error',
                        position: 'top-right',
                        loader: false,
                    });
                    return;
                }

                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;

                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'Xoá';
                        removeBtn.onclick = function() {
                            imagePreview.removeChild(divImgMulti);
                            document.getElementById(inputId).value = '';
                        };

                        const divImgMulti = document.createElement('div');
                        divImgMulti.classList.add('imgmulti');
                        divImgMulti.appendChild(img);
                        divImgMulti.appendChild(removeBtn);

                        imagePreview.appendChild(divImgMulti);
                    };
                    reader.readAsDataURL(files[i]);
                }
            }
        }
    </script>

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- PHẦN PHP ĐỂ GET LẠI CÁC VARIANT --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <?php
    // Tạo mảng trống để lưu trữ biến thể
    $selectedVariants = [];

    // Lặp qua các biến thể và thêm chúng vào mảng
    foreach ($product->variants as $variant) {
        // Chuyển các ID về dạng chuỗi và thêm chúng vào mảng biến thể
        $variantData = ['color' => strval($variant->color_id), 'size' => strval($variant->size_id), 'quantity' => strval($variant->quantity)];

        // Thêm mảng biến thể vào mảng selectedVariants
        $selectedVariants[] = $variantData;
    }

    // Chuyển đổi mảng PHP thành JSON để sử dụng trong JavaScript
    $selectedVariantsJSON = json_encode($selectedVariants);
    ?>
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- CÁC HÀM DÀNH CHO BIẾN THỂ --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <script>
        let selectedVariants = {!! $selectedVariantsJSON !!};
        let prevValidValue = '';
        // Lấy ra phần tử HTML của variantsInput
        const variantsInput = document.getElementById('variantsInput');

        // Duyệt qua mảng selectedVariants để hiển thị thông tin các biến thể đã tồn tại
        selectedVariants.forEach(variant => {
            const variantInput = document.createElement('input');
            variantInput.setAttribute('type', 'hidden');
            variantInput.setAttribute('name', 'variants[]');
            variantInput.setAttribute('value', JSON.stringify(variant));
            variantsInput.appendChild(variantInput);
        });

        function addVariant() {

            const colorSelect = document.getElementById('colorSelect');
            const sizeSelect = document.getElementById('sizeSelect');
            const quantityInput = document.getElementById('quantity');

            const selectedColor = colorSelect.value;
            const selectedSize = sizeSelect.value;
            const quantity = quantityInput.value;

            // Tạo một đối tượng JSON chứa thông tin biến thể
            const variantData = {
                color: selectedColor,
                size: selectedSize,
                quantity: quantity
            };


            // Kiểm tra có giá trị nào được chọn chưa
            if (!selectedColor || !selectedSize || !quantity) {
                $.toast({
                    heading: 'Cảnh báo',
                    text: 'Vui lòng chọn màu, kích thước và nhập số lượng',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
                return;
            }

            if (selectedColor === '0' || selectedSize === '0') {
                $.toast({
                    heading: 'Cảnh báo',
                    text: 'Vui lòng chọn màu và kích thước',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
                return;
            }

            if (quantity <= 0 || isNaN(quantity)) {
                $.toast({
                    heading: 'Cảnh báo',
                    text: 'Số lượng phải là số dương và không được là 0.',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
                return;
            }
            // Kiểm tra xem biến thể đã tồn tại chưa
            if (selectedVariants.some(variant => variant.color === selectedColor && variant.size === selectedSize)) {
                $.toast({
                    heading: 'Cảnh báo',
                    text: 'Màu và kích thước này đã được chọn',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
                return;
            }
            selectedVariants.push(variantData);

            const variantsContainer = document.getElementById('variants');
            const variantRow = document.createElement('div');
            variantRow.classList.add('variant-row');

            const colorDiv = document.createElement('div');
            colorDiv.classList.add('color-name');
            colorDiv.textContent = `${colorSelect.options[colorSelect.selectedIndex].text}`;

            const sizeDiv = document.createElement('div');
            sizeDiv.classList.add('size-name');
            sizeDiv.textContent = `${sizeSelect.options[sizeSelect.selectedIndex].text}`;

            const quantityInputDiv = document.createElement('input');
            quantityInputDiv.classList.add('quantity-input');
            quantityInputDiv.setAttribute('type', 'text');
            quantityInputDiv.setAttribute('value', quantity);
            quantityInputDiv.setAttribute('readonly', 'true');

            quantityInputDiv.addEventListener('input', function(event) {
                const inputValue = event.target.value;
                if (!(/^\d*\.?\d*$/.test(inputValue))) {
                    $.toast({
                        heading: 'Cảnh báo',
                        text: 'Vui lòng nhập số.',
                        hideAfter: 3000,
                        icon: 'error',
                        position: 'top-right',
                        loader: false,
                    });
                    event.target.value = prevValidValue; // Sử dụng giá trị trước đó nếu giá trị nhập không hợp lệ
                } else {
                    prevValidValue = inputValue; // Lưu trữ giá trị hợp lệ
                }
            });

            // Tạo các nút chỉnh sửa và xóa
            const editButton = document.createElement('a');
            editButton.classList.add('edit-quantity');
            editButton.textContent = 'Chỉnh sửa';

            const removeButton = document.createElement('a');
            removeButton.classList.add('remove-variant');
            removeButton.textContent = 'Xóa';

            const confirmButton = document.createElement('a');
            confirmButton.classList.add('confirm-edit');
            confirmButton.textContent = 'Xác nhận';
            confirmButton.style.display = 'none';

            const cancelButton = document.createElement('a');
            cancelButton.classList.add('cancel-edit');
            cancelButton.textContent = 'Hủy bỏ';
            cancelButton.style.display = 'none';


            variantRow.appendChild(colorDiv);
            variantRow.appendChild(sizeDiv);
            variantRow.appendChild(quantityInputDiv);
            variantRow.appendChild(editButton);
            variantRow.appendChild(removeButton);
            variantRow.appendChild(confirmButton);
            variantRow.appendChild(cancelButton);

            // Tạo một input ẩn để lưu thông tin biến thể và thêm vào form
            const variantsInput = document.getElementById('variantsInput');
            const variantInput = document.createElement('input');
            variantInput.setAttribute('type', 'hidden');
            variantInput.setAttribute('name', 'variants[]'); // Đặt tên cho biến thể để server có thể nhận diện
            variantInput.setAttribute('value', JSON.stringify(variantData)); // Lưu thông tin biến thể dưới dạng chuỗi JSON
            variantsInput.appendChild(variantInput);

            variantsContainer.appendChild(variantRow);
            // Reset các dropdown và input sau khi thêm
            colorSelect.value = '0';
            sizeSelect.value = '0';
            quantityInput.value = '';

            // Làm mới lại các Select2
            $('#colorSelect').val(null).trigger('change');
            $('#sizeSelect').val(null).trigger('change');

        }

        document.addEventListener('input', function(e) {
            if (e.target && e.target.classList.contains('quantity-input')) {
                const parentRow = e.target.parentNode;
                const variantIndex = Array.from(parentRow.parentNode.children).indexOf(parentRow);
                const newValue = e.target.value;

                // Cập nhật giá trị quantity mới vào selectedVariants
                if (variantIndex !== -1) {
                    selectedVariants[variantIndex].quantity = newValue;
                }

                // Cập nhật giá trị quantity mới vào input tương ứng trong variantsInput
                const variantsInput = document.getElementById('variantsInput');
                const variantInputs = variantsInput.querySelectorAll('input[name="variants[]"]');
                if (variantInputs.length > variantIndex) {
                    variantInputs[variantIndex].setAttribute('value', JSON.stringify(selectedVariants[
                        variantIndex]));
                }
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('edit-quantity')) {
                const parentRow = e.target.parentNode;
                const quantityInput = parentRow.querySelector('.quantity-input');
                const editButton = parentRow.querySelector('.edit-quantity');
                const removeButton = parentRow.querySelector('.remove-variant');
                const cancelButton = parentRow.querySelector('.cancel-edit');
                const confirmButton = parentRow.querySelector('.confirm-edit');

                editButton.style.display = 'none';
                removeButton.style.display = 'none';
                cancelButton.style.display = 'inline-block';
                confirmButton.style.display = 'inline-block';

                quantityInput.removeAttribute('readonly');
            }

            if (e.target && e.target.classList.contains('cancel-edit')) {
                const parentRow = e.target.parentNode;
                const quantityInput = parentRow.querySelector('.quantity-input');
                const editButton = parentRow.querySelector('.edit-quantity');
                const removeButton = parentRow.querySelector('.remove-variant');
                const cancelButton = parentRow.querySelector('.cancel-edit');
                const confirmButton = parentRow.querySelector('.confirm-edit');

                editButton.style.display = 'inline-block';
                removeButton.style.display = 'inline-block';
                cancelButton.style.display = 'none';
                confirmButton.style.display = 'none';

                quantityInput.setAttribute('readonly', 'true');
                quantityInput.value = quantityInput.defaultValue;
            }

            if (e.target && e.target.classList.contains('confirm-edit')) {
                const parentRow = e.target.parentNode;
                const quantityInput = parentRow.querySelector('.quantity-input');
                const editButton = parentRow.querySelector('.edit-quantity');
                const removeButton = parentRow.querySelector('.remove-variant');
                const cancelButton = parentRow.querySelector('.cancel-edit');
                const confirmButton = parentRow.querySelector('.confirm-edit');

                const inputValue = quantityInput.value;

                if (inputValue === '0') {
                    $.toast({
                        heading: 'Cảnh báo',
                        text: 'Không thể lưu giá trị 0.',
                        hideAfter: 3000,
                        icon: 'error',
                        position: 'top-right',
                        loader: false,
                    });
                } else {
                    editButton.style.display = 'inline-block';
                    removeButton.style.display = 'inline-block';
                    cancelButton.style.display = 'none';
                    confirmButton.style.display = 'none';

                    quantityInput.setAttribute('readonly', 'true');
                    quantityInput.defaultValue = inputValue;
                    prevValidValue = inputValue;
                }
            }

            if (e.target && e.target.classList.contains('remove-variant')) {
                const parentRow = e.target.parentNode;
                const variantId = parentRow.getAttribute('data-variant-id');
                const variantIndex = Array.from(parentRow.parentNode.children).indexOf(parentRow);
                console.log(variantIndex);
                const confirmDelete = Swal.fire({
                    title: "Thông báo",
                    text: `Bạn có chắc chắn muốn xóa biến thể không?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#34c3af",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Đồng ý xoá",
                    cancelButtonText: "Huỷ bỏ"
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (variantIndex !== -1) {

                            if (variantId) {

                                // Gọi endpoint để xóa biến thể khỏi database
                                axios.delete(`/admin/products/delete-variant/${variantId}`)
                                    .then(response => {
                                        // Xoá thành công, có thể thực hiện các thao tác cần thiết
                                        $.toast({
                                            heading: 'Thành công',
                                            text: 'Đã xoá thành công',
                                            hideAfter: 3000,
                                            icon: 'success',
                                            position: 'top-right',
                                            loader: false,
                                        });
                                        // Sau khi xóa thành công, xóa biến thể khỏi giao diện
                                        selectedVariants.splice(variantIndex, 1);
                                        parentRow.remove();

                                        // Cập nhật lại giá trị ẩn trong variantsInput
                                        const variantsInput = document.getElementById('variantsInput');
                                        const variantInputs = variantsInput.querySelectorAll(
                                            'input[name="variants[]"]');
                                        if (variantInputs.length > variantIndex) {
                                            variantInputs[variantIndex]
                                                .remove(); // Xóa phần tử ẩn tương ứng với biến thể đã xóa
                                        }
                                    })
                                    .catch(error => {
                                        // Xử lý lỗi nếu có
                                        if (error.response && error.response.status === 400) {
                                            // Hiển thị thông báo lỗi từ server
                                            const errorMessage = error.response.data.error;
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Lỗi',
                                                text: errorMessage,
                                            });
                                        } else {
                                            // Xử lý lỗi không xác định
                                            console.error('Error:', error);
                                            // Hiển thị thông báo lỗi mặc định
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Lỗi',
                                                text: 'Đã xảy ra lỗi khi xóa biến thể.',
                                            });
                                        }
                                    });
                            } else {
                                $.toast({
                                    heading: 'Thành công',
                                    text: 'Đã xoá thành công',
                                    hideAfter: 3000,
                                    icon: 'success',
                                    position: 'top-right',
                                    loader: false,
                                });
                                selectedVariants.splice(variantIndex, 1);
                                parentRow.remove();

                                // Cập nhật lại giá trị ẩn trong variantsInput
                                const variantsInput = document.getElementById('variantsInput');
                                const variantInputs = variantsInput.querySelectorAll(
                                    'input[name="variants[]"]');
                                if (variantInputs.length > variantIndex) {
                                    variantInputs[variantIndex]
                                        .remove(); // Xóa phần tử ẩn tương ứng với biến thể đã xóa
                                }
                            }

                        }
                    }
                });
            }

        });
    </script>
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- CÁC validateSubmit --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <script>
        function validateForm() {
            const imagePreview = document.getElementById('imagePreview');
            const variants = document.getElementById('variants');
            const avtImage = document.getElementById('preview');
            if (!imagePreview || !imagePreview.firstChild) {
                alert('Vui lòng tải thêm album ảnh sản phẩm.');
                return false;
            }
            if (!variants || !variants.firstChild) {
                alert('Vui lòng thêm ít nhất một biến thể sản phẩm.');
                return false;
            }
            if (avtImage.src.includes('empty.jpg')) {
                alert('Vui lòng thêm hình đại diện cho sản phẩm.');
                return false;
            }

            // Nếu các điều kiện đều được đáp ứng, cho phép submit form
            return true;
        }
    </script>
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
@endsection

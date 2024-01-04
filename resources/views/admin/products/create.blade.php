<!-- create.blade.php -->
@extends('layouts.admin_layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between card flex-sm-row border-0">
                <h4 class="mb-sm-0 font-size-16 fw-bold">THÊM MỚI SẢN PHẨM</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách sản phẩm</a></li>
                        <li class="breadcrumb-item active">Thêm mới sản phẩm</li>
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
        <form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
            onsubmit="return validateForm()">
            @csrf
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
                            <div class="row" bis_skin_checked="1">
                                <div class="col-md-12" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="name_product" class="form-label">Tên sản phẩm</label>
                                        <input type="text" class="form-control" id="name_product" name="name_product"
                                            value="{{ old('name_product') }}">
                                    </div>
                                    @error('name_product')
                                        <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="sku" class="form-label">Mã sản phẩm</label>
                                        <a style="float: right;font-weight:600;color:rgb(0, 116, 194);cursor: pointer;"
                                            onclick="generateSKU()">Tự động tạo mã</a>
                                        <input type="text" class="form-control" id="sku" name="sku"
                                            value="{{ old('sku') }}">

                                    </div>
                                    @error('sku')
                                        <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <label for="link_product" class="form-label">Liên kết đường dẫn</label>
                                        <input type="text" class="form-control" id="link_product"
                                            value="{{ old('link_product') }}" name="link_product" readonly>
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
                                                        <option value="{{ $size->id }}">{{ $size->desc_size }}</option>
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
                                {{-- <div class="col-md-12" bis_skin_checked="1">
                                <div class="mb-3" bis_skin_checked="1">
                                    <label for="sortdesc_product" class="form-label">Mô tả ngắn</label>
                                    <textarea class="form-control " id="sortdesc_product" name="sortdesc_product" rows="6 ">{{ old('sortdesc_product') }}</textarea>
                                </div>
                            </div> --}}
                                <div class="mb-3" bis_skin_checked="1">
                                    <label for="desc_product" class="form-label">Mô tả sản phẩm</label>
                                    <textarea class="form-control ckeditor" id="desc_product" name="desc_product">{{ old('desc_product') }}</textarea>

                                </div>
                                @error('desc_product')
                                    <p class="alert alert-danger"> {{ $message }}</p>
                                @enderror
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
                                            <option value="" disabled selected hidden>Chọn danh mục</option>
                                            @foreach ($categoriesTree as $category)
                                                <option value="{{ $category->id }}">{{ $category->name_category }}
                                                </option>
                                                @if ($category->children)
                                                    @foreach ($category->children as $child)
                                                        @include('admin.products.child_category', [
                                                            'child' => $child,
                                                            'prefix' => '-',
                                                        ])
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
                                        <input type="text" value="{{ old('price_product') }}"
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
                                        <input type="text" value="{{ old('sellprice_product') }}"
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
                                            <button class="remove-add-avt" type="button" onclick="removeImage()"
                                                id="removeBtn" style="display: none;">Xoá</button>
                                            <img class="avt-img"
                                                src="{{ URL::to('backend_area/assets/images/empty.jpg') }}"
                                                id="preview">
                                            <button class="button-add-avt" id="chooseBtn" type="button"
                                                onclick="document.getElementById('avt_product').click();"></button>
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
                                            <div id="imagePreview"></div>
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

            if (!isNaN(price) && !isNaN(sellPrice)) {
                let discountPercent = ((price - sellPrice) / price) * 100;
                // Làm tròn số về nguyên
                discountInput.value = Math.round(discountPercent).toLocaleString('en-US');
            }
        }
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

        function removeImage() {
            const preview = document.getElementById('preview');
            const removeBtn = document.getElementById('removeBtn');
            const fileInput = document.getElementById('avt_product');
            const imageContainer = document.getElementById('imageContainer');
            const imageWrapper = document.getElementById('imageWrapper');

            preview.src = '{{ URL::to('backend_area/assets/images/empty.jpg') }}';
            preview.style.display = 'block';
            removeBtn.style.display = 'none';
            chooseBtn.style.display = 'block';
            fileInput.value = ''; // Xóa giá trị đã chọn trong input file
            imageContainer.style.display = 'block';
            imageWrapper.style.paddingTop = '10px'; // Hiển thị khoảng trắng dư thừa khi không có hình
        }
    </script>
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- HÀM DÀNH CHO ALBUM ẢNH --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <script>
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
    {{-- CÁC HÀM DÀNH CHO BIẾN THỂ --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    <script>
        let selectedVariants = [];
        let prevValidValue = '';

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

            const exists = selectedVariants.find(variant => variant.color === selectedColor && variant.size ===
                selectedSize);

            if (exists) {
                $.toast({
                    heading: 'Cảnh báo',
                    text: 'Màu và kích thước này đã được chọn',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
            } else {
                selectedVariants.push({
                    color: selectedColor,
                    size: selectedSize,
                    quantity: quantity
                });

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
                        event.target.value =
                        prevValidValue; // Sử dụng giá trị trước đó nếu giá trị nhập không hợp lệ
                    } else {
                        prevValidValue = inputValue; // Lưu trữ giá trị hợp lệ
                    }
                });

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
                variantInput.setAttribute('value', JSON.stringify(
                variantData)); // Lưu thông tin biến thể dưới dạng chuỗi JSON
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
        }

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
                const colorDiv = parentRow.querySelector('.color-name').textContent;
                const sizeDiv = parentRow.querySelector('.size-name').textContent;


                const confirmDelete = Swal.fire({
                    title: "Thông báo",
                    text: `Bạn có chắc chắn muốn xóa biến thể có màu ${colorDiv} và kích thước ${sizeDiv} không?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#34c3af",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Đồng ý xoá",
                    cancelButtonText: "Huỷ bỏ"
                }).then((result) => {
                    if (result.isConfirmed) {
                        parentRow.remove(); // Xóa hàng biến thể

                        // Xóa thông tin biến thể khỏi mảng selectedVariants
                        const indexToRemove = selectedVariants.findIndex(variant => variant.color ===
                            colorDiv && variant.size === sizeDiv);
                        if (indexToRemove !== -1) {
                            selectedVariants.splice(indexToRemove, 1);
                        }

                        // Cảnh báo đã xóa thành công
                        $.toast({
                            heading: 'Thông báo',
                            text: `Đã xóa biến thể có màu ${colorDiv} và kích thước ${sizeDiv}.`,
                            hideAfter: 3000,
                            icon: 'success',
                            position: 'top-right',
                            loader: false,
                        });
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
            const avtProductInput = document.getElementById('avt_product');
            const imageProductInput = document.getElementById('image_product');
            const variants = document.querySelectorAll('.variant-row');

            if (!avtProductInput || !avtProductInput.files || avtProductInput.files.length === 0) {
                $.toast({
                    heading: 'Lỗi',
                    text: 'Vui lòng chọn hình đại diện sản phẩm.',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
                return false; // Ngăn form submit nếu chưa chọn hình đại diện
            }
            if (!variants || variants.length === 0) {
                $.toast({
                    heading: 'Lỗi',
                    text: 'Vui lòng thêm ít nhất một thuộc tính màu và kích thước.',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
                return false; // Ngăn form submit nếu chưa thêm thuộc tính màu và kích thước
            }
            if (!imageProductInput || !imageProductInput.files || imageProductInput.files.length === 0) {
                $.toast({
                    heading: 'Lỗi',
                    text: 'Vui lòng chọn album ảnh sản phẩm.',
                    hideAfter: 3000,
                    icon: 'error',
                    position: 'top-right',
                    loader: false,
                });
                return false; // Ngăn form submit nếu chưa chọn album ảnh sản phẩm
            }

            return true; // Cho phép submit form nếu đã chọn cả hình đại diện và album ảnh sản phẩm
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

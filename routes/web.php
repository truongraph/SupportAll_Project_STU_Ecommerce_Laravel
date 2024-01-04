<?php
use Illuminate\Support\Facades\Route;
//===========================================
//===========================================
//===========================================
// FRONTEND
//===========================================
//===========================================
//===========================================
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DiscountController;
//===========================================
//===========================================
//===========================================
// BACKEND
//===========================================
//===========================================
//===========================================
//===========================================
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminColorController;
use App\Http\Controllers\Admin\AdminSizeController;
use App\Http\Controllers\Admin\AdminEmailConfigController;
use App\Http\Controllers\Admin\AdminDiscountController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminBannerController;

//==============================================================
//===========================================
//===========================================
//===========================================
// FRONTEND
//===========================================
//===========================================
//===========================================
Route::get('/', [HomeController::class, 'index']);
Route::get('/ve-chung-toi', [AboutController::class, 'index']);
Route::get('/lienhe', [ContactController::class, 'index']);
Route::post('/send-email', [ContactController::class, 'sendEmail'])->name('contact.send');
Route::get('/search', [SearchController::class, 'index']);
//==============================================
//========= Đăng nhập =========================
Route::get('/login', [AccountController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AccountController::class, 'loginSubmit'])->name('login.submit');
Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
//===========================================
//=========  Đăng ký  =======================
Route::get('/register', [AccountController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AccountController::class, 'register'])->name('register.submit');
//===========================================
//============ Quên mật khẩu ================
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot.password.form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot.password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');
//===========================================
//======= Quản lý tài khoản cá nhân =========
Route::get('/myaccount', [AccountController::class, 'myAccount'])->name('myaccount')->middleware('auth.account');
Route::post('/update-customer-info', [AccountController::class, 'updateCustomerInfo'])->name('update.customer.info');
//===========================================
//========= Thay đổi mật khẩu ===============
Route::get('/change-password', [AccountController::class, 'showChangePasswordForm'])->name('change.password.view');
Route::post('/change-password', [AccountController::class, 'changePassword'])->name('change.password');
//===========================================
//========== Danh mục ========================
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
//===========================================
//=========== Sản phẩm =======================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{linkProduct}', [ProductController::class, 'show'])->name('products.show');
Route::post('/get-quantity', [ProductController::class, 'getQuantity'])->name('get.quantity');
//===========================================
//=========== Giỏ hàng =======================
Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::delete('/cart/remove', [CartController::class, 'removeFromCart']);
Route::post('/cart/change-quantity', [CartController::class, 'changeQuantity']);
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
//===========================================
//=========== Thanh toán ====================
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/apply-discount', [CheckoutController::class, 'applyDiscount'])->name('apply.discount');
Route::post('/remove-discount', [CheckoutController::class, 'removeDiscount'])->name('remove.discount');
//===========================================
//=========== Khuyến mãi ====================
Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
//===========================================
//=========== Xem chi tiết, tìm đơn =========
Route::get('/order/{orderId}/detail', [OrderController::class, 'orderDetail'])->name('order.detail');
Route::post('/order/search', [OrderController::class, 'search'])->name('order.search');
Route::get('/order/search', [OrderController::class, 'showSearchForm'])->name('order.search.view');
//===========================================
//=========== Hủy đơn =======================
Route::get('/cancel-order/{orderId}', [OrderController::class, 'cancelOrder'])->name('cancel.order');
//==============================================================
//===========================================
//===========================================
//===========================================
// BACKEND
//===========================================
//===========================================
//===========================================
Route::get('/admin/login', [LoginController::class, 'showLogin'])->name('admin.showlogin');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::redirect('.env', '/');
Route::middleware(['admin.auth'])->group(function () {
    //========================================================
    //========================================================
    Route::get('/admin', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    //========================================================
    //============= Quản lý Tài khoản khách hàng==============
    Route::get('/admin/accounts', [AdminAccountController::class, 'index'])->name('admin.accounts.index');
    Route::get('/admin/accounts/{id}/edit', [AdminAccountController::class, 'edit'])->name('admin.accounts.edit');
    Route::put('/admin/accounts/{id}', [AdminAccountController::class, 'update'])->name('admin.accounts.update');
    Route::get('/admin/accounts/{id}/block', [AdminAccountController::class, 'block'])->name('admin.accounts.block');
    Route::get('/admin/accounts/{id}', [AdminAccountController::class, 'blockacc'])->name('admin.accounts.blockacc');
    Route::get('/admin/accounts/delete/{id}', [AdminAccountController::class, 'delete'])->name('admin.accounts.delete');
    //========================================================
    //============ Quản lý khách hàng =========================
    Route::get('/admin/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/admin/customers/create', [AdminCustomerController::class, 'create'])->name('admin.customers.create');
    Route::post('/admin/customers/store', [AdminCustomerController::class, 'store'])->name('admin.customers.store');
    Route::get('/admin/customers/{id}/edit', [AdminCustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::put('/admin/customers/{id}', [AdminCustomerController::class, 'update'])->name('admin.customers.update');
    Route::get('/admin/customers/delete/{id}', [AdminCustomerController::class, 'delete'])->name('admin.customers.delete');
    //========================================================
    //=============== Quản lý danh mục =======================
    Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::get('/admin/categories/delete/{id}', [AdminCategoryController::class, 'delete'])->name('admin.categories.delete');
    //========================================================
    //============== Quản ký màu sắc =========================
    Route::get('/admin/colors', [AdminColorController::class, 'index'])->name('admin.colors.index');
    Route::post('/admin/colors/store', [AdminColorController::class, 'store'])->name('admin.colors.store');
    Route::get('/admin/colors/delete/{id}', [AdminColorController::class, 'delete'])->name('admin.colors.delete');
    Route::get('/admin/colors/edit/{id}', [AdminColorController::class, 'edit'])->name('admin.colors.edit');
    Route::put('/admin/colors/update/{id}', [AdminColorController::class, 'update'])->name('admin.colors.update');
    //========================================================
    //============== Quản lý kích thước ======================
    Route::get('/admin/sizes', [AdminSizeController::class, 'index'])->name('admin.sizes.index');
    Route::post('/admin/sizes/store', [AdminSizeController::class, 'store'])->name('admin.sizes.store');
    Route::get('/admin/sizes/delete/{id}', [AdminSizeController::class, 'delete'])->name('admin.sizes.delete');
    Route::get('/admin/sizes/edit/{id}', [AdminSizeController::class, 'edit'])->name('admin.sizes.edit');
    Route::put('/admin/sizes/update/{id}', [AdminSizeController::class, 'update'])->name('admin.sizes.update');
    //========================================================
    //============= Quản lý sản phẩm =========================
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/delete/{id}', [AdminProductController::class, 'delete'])->name('admin.products.delete');
    Route::get('/admin/products/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/update/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/delete-variant/{id}', [AdminProductController::class, 'deleteVariant'])->name('delete.variant');
   //========================================================
   //============= Quản lý đơn hàng ==========================
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('admin/orders/update_status/{id}/{status}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update_status');
    Route::get('/admin/orders/delete/{id}', [AdminOrderController::class, 'delete'])->name('admin.orders.delete');
    Route::get('/admin/orders/view/{id}', [AdminOrderController::class, 'view'])->name('admin.orders.view');
    Route::get('admin/orders/{id}/print', [AdminOrderController::class, 'printInvoice'])->name('admin.orders.print');
    //========================================================
    //============= Quản lý mã khuyến mãi ===================
    Route::get('/admin/discounts', [AdminDiscountController::class, 'index'])->name('admin.discounts.index');
    Route::get('/admin/discounts/create', [AdminDiscountController::class, 'create'])->name('admin.discounts.create');
    Route::post('/admin/discounts/store', [AdminDiscountController::class, 'store'])->name('admin.discounts.store');
    Route::get('/admin/discounts/delete/{id}', [AdminDiscountController::class, 'delete'])->name('admin.discounts.delete');
    Route::get('/admin/discounts/edit/{id}', [AdminDiscountController::class, 'edit'])->name('admin.discounts.edit');
    Route::put('/admin/discounts/update/{id}', [AdminDiscountController::class, 'update'])->name('admin.discounts.update');
    //========================================================
    //============== Quản lý banner ============================
    Route::get('/admin/banners', [AdminBannerController::class, 'index'])->name('admin.banners.index');
    Route::post('/admin/banners/store', [AdminBannerController::class, 'store'])->name('admin.banners.store');
    Route::get('/admin/banners/delete/{id}', [AdminBannerController::class, 'delete'])->name('admin.banners.delete');
    Route::get('/admin/banners/activate/{id}', [AdminBannerController::class, 'activate'])->name('admin.banners.activate');

});

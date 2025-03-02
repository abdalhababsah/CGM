<?php

use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\DiscountCodeController;
use App\Http\Controllers\Admin\HairPoreController;
use App\Http\Controllers\Admin\HairThicknessController;
use App\Http\Controllers\Admin\HairTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;

// Change language
Route::get('/lang/{locale}', [LocalizationController::class, 'switchLang'])->name('lang.switch');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin Routes Group
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    //  areas route
    Route::resource('areas', AreaController::class)->except(['show']);
    // Brand Routes
    Route::resource('brands', BrandController::class);
    // Category Routes
    Route::resource('categories', CategoryController::class);
    // Delivery Locations and Prices Routes
    Route::resource('deliveries', DeliveryController::class);
    // Orders
    Route::get('orders', [AdminOrdersController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrdersController::class, 'show'])->name('orders.show');
    Route::get('ordersl/resend/{order}', [AdminOrdersController::class, 'resend'])->name('orders.resend');
    Route::get('admin/orders/{order}/invoice', [AdminOrdersController::class, 'downloadInvoice'])->name('orders.invoice.download');
    // Discounts
    Route::resource('users', UserController::class);


    Route::resource('discount', DiscountCodeController::class);
    // cms-management home section
    Route::resource('cms-management', CmsController::class);
    //header top slider update
    Route::put('cms-management/header-slider/{slider}', [CmsController::class, 'updateHeader'])->name('header-slider.update');
    // Hair Thickness Routes
    Route::resource('hair-thickness', HairThicknessController::class)->except(['show']);

    // Hair Type Routes
    Route::resource('hair-type', HairTypeController::class)->except(['show']);

    // Hair Pore Routes
    Route::resource('hair-pore', HairPoreController::class)->except(['show']);
    Route::get('products', [AdminProductsController::class, 'index'])->name('products.index');
    Route::get('products/create', [AdminProductsController::class, 'create'])->name('products.create');
    Route::post('products', [AdminProductsController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [AdminProductsController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [AdminProductsController::class, 'destroy'])->name('products.destroy');
    // import products
    Route::post('/import', [AdminProductsController::class, 'import'])->name('products.import');

    // Partial Updates for Products

    Route::put('products/{product}/general-info', [AdminProductsController::class, 'updateGeneralInfo'])->name('products.updateGeneralInfo');
    Route::put('products/{product}/options', [AdminProductsController::class, 'updateOptions'])->name('products.updateOptions');
    // Image Management Routes
    Route::post('products/{product}/additional-images', [AdminProductsController::class, 'uploadAdditionalImages'])->name('products.uploadAdditionalImages');
    Route::put('products/{product}/primary-image', [AdminProductsController::class, 'updatePrimaryImage'])->name('products.updatePrimaryImage');
    Route::get('products/{product}/fetch-images', [AdminProductsController::class, 'fetchImages'])->name('products.fetchImages');
    Route::delete('products/images/{image}', [AdminProductsController::class, 'deleteImage'])->name('products.deleteImage');
});



// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




// Wishlist Routes
Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishListController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishListController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/toggle', [WishListController::class, 'toggle'])->name('wishlist.toggle');




// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart-tems', [CartController::class, 'fetchCart'])->name('fetchCart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');




// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/fetch-products', [ShopController::class, 'fetchProducts'])->name('shop.fetchProducts');
//view products
Route::get('/view-product/{product}/{slug}', [ProductController::class, 'show'])->name('product.show');


// User Dashboard Routes
Route::middleware(['auth', 'user'])->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('orders/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});



// Checkout Routes
Route::middleware(['auth'])->prefix('checkout')->name('checkout.')->group(function () {
    // Display the checkout page
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::get('/fetch-checkout', [CheckoutController::class, 'fetchCheckout'])->name('checkout.fetch');
    // Fetch delivery locations via AJAX
    Route::get('/fetch-delivery-locations', [CheckoutController::class, 'fetchDeliveryLocations'])->name('fetchDeliveryLocations');
    Route::get('/checkout/fetch-areas', [CheckoutController::class, 'fetchAreas'])->name('checkout.fetchAreas');

    // Apply a discount code via AJAX
    Route::post('/apply-discount-code', [CheckoutController::class, 'applyDiscountCode'])->name('applyDiscountCode');
    // Remove an applied discount code via AJAX
    Route::post('/remove-discount-code', [CheckoutController::class, 'removeDiscountCode'])->name('removeDiscountCode');
    // Submit the checkout form via AJAX
    Route::post('/submit', [CheckoutController::class, 'submit'])->name('submit');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});



// Contact Us Route
Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact');
Route::post('/contact-us', [ContactUsController::class, 'submit'])->name('contact.submit');
Route::get('/test-get-areas', [TestController::class, 'testGetAreas'])->name('test.getAreas');



require __DIR__ . '/auth.php';

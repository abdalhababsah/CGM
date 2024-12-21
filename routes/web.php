<?php

use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\DiscountCodeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;



// change language
Route::get('/lang/{locale}', [LocalizationController::class, 'switchLang'])->name('lang.switch');// Profile Routes
// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');


// Admin Routes Group
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Brand Routes
    Route::resource('brands', BrandController::class);
    // Category Routes
    Route::resource('categories', CategoryController::class);
    // Delivery Locations and Prices Routes
    Route::resource('deliveries', DeliveryController::class);
    // orders
    Route::get('orders', [AdminOrdersController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrdersController::class, 'show'])->name('orders.show');
    Route::get('admin/orders/{order}/invoice', [AdminOrdersController::class, 'downloadInvoice'])->name('orders.invoice.download');
    // discounts
    Route::resource('discount', DiscountCodeController::class);
    // Products
    Route::get('products', [AdminProductsController::class, 'index'])->name('products.index');
    Route::get('products/create', [AdminProductsController::class, 'create'])->name('products.create');
    Route::post('products', [AdminProductsController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [AdminProductsController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [AdminProductsController::class, 'destroy'])->name('products.destroy');
    // Partial Updates for Products
    Route::put('products/{product}/general-info', [AdminProductsController::class, 'updateGeneralInfo'])->name('products.updateGeneralInfo');
    Route::put('products/{product}/options', [AdminProductsController::class, 'updateOptions'])->name('products.updateOptions');
    // Image Management Routes
    Route::post('products/{product}/additional-images', [AdminProductsController::class, 'uploadAdditionalImages'])->name('products.uploadAdditionalImages');
    Route::post('products/{product}/primary-image', [AdminProductsController::class, 'updatePrimaryImage'])->name('products.updatePrimaryImage');
    Route::delete('products/images/{image}', [AdminProductsController::class, 'deleteImage'])->name('products.deleteImage');
    Route::delete('products/{product}/primary-image', [AdminProductsController::class, 'deletePrimaryImage'])->name('products.deletePrimaryImage');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
// for the count in the header
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

// Wishlist Routes
Route::get('/wishlist', [App\Http\Controllers\WishListController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [App\Http\Controllers\WishListController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [App\Http\Controllers\WishListController::class, 'remove'])->name('wishlist.remove');

// toglle to remove or add to wish list
Route::post('/wishlist/toggle', [WishListController::class, 'toggle'])->name('wishlist.toggle');
// Shop route
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Route to handle AJAX requests for fetching products, categories, and brands
Route::get('/shop/fetch-products', [ShopController::class, 'fetchProducts'])->name('shop.fetchProducts');



Route::middleware(['auth', 'user'])->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->prefix('checkout')->name('checkout.')->group(function () {
    // Display the checkout page
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::get('/fetch-checkout', [CheckoutController::class, 'fetchCheckout'])->name('checkout.fetch');
    // Fetch delivery locations via AJAX
    Route::get('/fetch-delivery-locations', [CheckoutController::class, 'fetchDeliveryLocations'])->name('fetchDeliveryLocations');

    // Get delivery price based on selected location via AJAX
    Route::post('/get-delivery-price', [CheckoutController::class, 'getDeliveryPrice'])->name('getDeliveryPrice');

    // Apply a discount code via AJAX
    Route::post('/apply-discount-code', [CheckoutController::class, 'applyDiscountCode'])->name('applyDiscountCode');

    // Remove an applied discount code via AJAX
    Route::post('/remove-discount-code', [CheckoutController::class, 'removeDiscountCode'])->name('removeDiscountCode');

    // Submit the checkout form via AJAX
    Route::post('/submit', [CheckoutController::class, 'submit'])->name('submit');

    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

Route::get('/contact', [ContactUsController::class, 'index'])->name('contact');


require __DIR__ . '/auth.php';
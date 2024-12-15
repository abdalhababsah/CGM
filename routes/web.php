<?php

use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard Route for Authenticated and Verified Users
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes Group
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
     // Brand Routes
    Route::resource('brands', BrandController::class);
    // Category Routes
    Route::resource('categories', CategoryController::class);
    // orders
    Route::get('orders', [AdminOrdersController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrdersController::class, 'show'])->name('orders.show');
    Route::get('admin/orders/{order}/invoice', [AdminOrdersController::class, 'downloadInvoice'])->name('orders.invoice.download');
    // products
    Route::get('products', [AdminProductsController::class, 'index'])->name('products.index');
    Route::get('products/create', [AdminProductsController::class, 'create'])->name('products.create');
    Route::post('products', [AdminProductsController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [AdminProductsController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [AdminProductsController::class, 'destroy'])->name('products.destroy');
});

Route::get('/lang/{locale}', [LocalizationController::class, 'switchLang'])->name('lang.switch');// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/wishlist', [WishListController::class,'index'])->name('wishlist.index');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
// Route to display the shop page



Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Route to handle AJAX requests for fetching products, categories, and brands
Route::get('/shop/fetch-products', [ShopController::class, 'fetchProducts'])->name('shop.fetchProducts');

// Include Auth Routes
require __DIR__.'/auth.php';
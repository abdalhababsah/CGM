<?php

use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

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
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include Auth Routes
require __DIR__.'/auth.php';
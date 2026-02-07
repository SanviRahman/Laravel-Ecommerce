<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GuestOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'home'])->name('index');
Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('products/{id}', [UserController::class, 'productDetails'])->name('product.details');
Route::get('/viewallproducts', [UserController::class, 'viewAllProducts'])->name('viewallproducts');

// Order Routes
// Guest Order Routes (No Auth Required)
Route::post('/confirm-order', [CartController::class, 'confirmOrder'])->name('confirm_order');
Route::get('/order-success/{id}', [CartController::class, 'orderSuccess'])->name('order.success');

// Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/showallcarts', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::put('/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::get('/count', [CartController::class, 'getCartCountApi'])->name('cart.count');
    Route::get('/data', [CartController::class, 'getCartData'])->name('cart.data');
});

// User Profile Routes (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Guest user order tracking routes (No Auth Required)
Route::prefix('track-order')->name('guest.')->group(function () {
    Route::get('/', [GuestOrderController::class, 'trackOrder'])->name('track.order');
    Route::post('/', [GuestOrderController::class, 'trackOrderPost'])->name('track.order.post');
    Route::get('/{order_number}', [GuestOrderController::class, 'showOrderDetails'])->name('order.details');
    Route::post('/{order_number}/send-details', [GuestOrderController::class, 'sendOrderDetails'])->name('order.send.details');
});

// Admin Routes
// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Category Routes
    Route::get('/categories', [AdminController::class, 'categoryIndex'])->name('categories.index');
    Route::get('/categories/create', [AdminController::class, 'addCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');

    // Product Routes
    Route::get('/products', [AdminController::class, 'productIndex'])->name('products.index');
    Route::get('/product/create', [AdminController::class, 'productCreate'])->name('products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'productEdit'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'productDelete'])->name('products.delete');
    Route::get('/product/search', [AdminController::class, 'productSearch'])->name('products.search');

    // Admin View Orders Route
    Route::get('/orders', [AdminController::class, 'viewOrders'])->name('orders.view');
    Route::get('/orders/search', [AdminController::class, 'viewOrders'])->name('orders.search');
    Route::get('/orders/{id}/edit', [AdminController::class, 'editOrder'])->name('orders.edit');
    Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('orders.update');

    // Order Status Management (AJAX-free)
    Route::get('/orders/{id}/update-status', [AdminController::class, 'showUpdateStatusForm'])->name('orders.update-status.form');
    Route::post('/orders/{id}/update-status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');

    //Download Invoice Route
    Route::get('/{order_number}/invoice', [AdminController::class, 'downloadInvoice'])->name('order.invoice');
});
require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
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

// Track Order (Optional)
Route::get('/track-order', [CartController::class, 'trackOrder'])->name('order.track');
Route::post('/track-order', [CartController::class, 'trackOrderPost'])->name('order.track.post');




// Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/showallcarts', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::put('/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::get('/count', [CartController::class, 'getCartCountApi'])->name('cart.count');
    Route::get('/data', [CartController::class, 'getCartData'])->name('cart.data');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

    // View Orders Route
    //Route::get('/orders', [AdminController::class, 'viewOrders'])->name('admin.orders');
    Route::get('/orders', [AdminController::class, 'viewOrders'])->name('orders.view');
    Route::get('/orders/search', [AdminController::class, 'viewOrders'])->name('orders.search');
    Route::get('/orders/{id}', [AdminController::class, 'viewOrder'])->name('orders.show');
    Route::get('/orders/{id}/edit', [AdminController::class, 'editOrder'])->name('orders.edit');
    Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('orders.update');
    
    // Order Status Management
    Route::get('/orders/{id}/status', [AdminController::class, 'getOrderStatus'])->name('orders.status');
    Route::post('/orders/{id}/update-status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    
    // Export
    Route::get('/orders/export', [AdminController::class, 'exportOrders'])->name('orders.export');

});

require __DIR__ . '/auth.php';

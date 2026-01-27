<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/dashboard',[UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'productEdit'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'productDelete'])->name('products.delete');

});



require __DIR__.'/auth.php';

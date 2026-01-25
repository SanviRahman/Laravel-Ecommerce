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


Route::middleware(['auth', 'admin'])->group(function () {
    // Category List (সব ক্যাটাগরি দেখাবে)
    Route::get('/categories', [AdminController::class, 'categoryIndex'])->name('categories.index');
    // Create Category Form (ফর্ম দেখাবে)
    Route::get('/categories/create', [AdminController::class, 'addCategory'])->name('categories.create');
    // Store Category (ফর্ম সাবমিট করবে)
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    // Edit Category Form (এডিট ফর্ম দেখাবে)
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    // Update Category (এডিট ফর্ম আপডেট করবে)
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    // Delete Category (ক্যাটাগরি ডিলিট করবে)
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
});



require __DIR__.'/auth.php';

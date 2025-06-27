<?php

use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\AuthController;
Use App\Http\Controllers\AdminController;
Use App\Http\Controllers\ProductController;
Use App\Http\Controllers\CategoryController;
Use App\Http\Controllers\ReceiptController;




Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::get('/track', [ReceiptController::class, 'customer'])->name('receipt.customer');
Route::get('/tracking', [ReceiptController::class, 'track'])->name('receipt.track');
// Admin Login
Route::get('/admin/login', [AuthController::class, 'index'])->name('login');
Route::post('/admin/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::group(['middleware' => ['auth', 'checkRole']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Produk dan Jasa
    Route::get('/admin/products', [AdminController::class, 'index'])->name('product');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('store.product');
    Route::put('/admin/products/update/{id}', [ProductController::class, 'update'])->name('update.product');
    Route::delete('/admin/products/delete/{id}', [ProductController::class, 'destroy'])->name('destroy.product');


    // Category
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/admin/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/admin/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    
    // Receipt
    Route::get('/admin/receipt', [ReceiptController::class, 'index'])->name('receipt.index');
    Route::post('/admin/receipt', [ReceiptController::class, 'store'])->name('receipt.store');
    Route::put('/admin/receipt/update/{id}', [ReceiptController::class, 'update'])->name('receipt.update');
    Route::delete('/admin/receipt/delete/{id}', [ReceiptController::class, 'destroy'])->name('receipt.destroy');
});



?>

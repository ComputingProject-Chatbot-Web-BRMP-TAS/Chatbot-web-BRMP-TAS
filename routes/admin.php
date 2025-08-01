<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\customer\ComplaintController;

// =====================
// ADMIN ROUTES
// =====================
Route::group(['prefix' => 'ADMIN-BRMP-TAS'], function () {
    // Admin Auth (Guest)
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
    
    // Admin Dashboard (Authenticated)
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/komplain', [ComplaintController::class, 'index'])->name('complaint.index');
        Route::get('/komplain/{id}', [ComplaintController::class, 'show'])->name('complaint.show');
        
        // Admin menu routes
        Route::get('/products', [App\Http\Controllers\admin\ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [App\Http\Controllers\admin\ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [App\Http\Controllers\admin\ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{id}', [App\Http\Controllers\admin\ProductController::class, 'show'])->name('admin.products.show');
        Route::get('/products/{id}/edit', [App\Http\Controllers\admin\ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{id}', [App\Http\Controllers\admin\ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [App\Http\Controllers\admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
        Route::get('/products/{id}/history', [App\Http\Controllers\admin\ProductController::class, 'history'])->name('admin.products.history');
        
        Route::get('/transactions', [AdminDashboardController::class, 'transactions'])->name('admin.transactions');
        Route::get('/articles', [AdminDashboardController::class, 'articles'])->name('admin.articles');
        
        // Admin Logout
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
}); 
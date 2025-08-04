<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\ComplaintController;

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
        
        // Complaint routes
        Route::get('/complaints', [ComplaintController::class, 'index'])->name('admin.complaints.index');
        Route::get('/complaints/{id}', [ComplaintController::class, 'show'])->name('admin.complaints.show');
        Route::get('/complaints-dashboard', [ComplaintController::class, 'dashboard'])->name('admin.complaints.dashboard');
        
        // Admin menu routes
        Route::get('/products', [App\Http\Controllers\admin\ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [App\Http\Controllers\admin\ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [App\Http\Controllers\admin\ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{id}', [App\Http\Controllers\admin\ProductController::class, 'show'])->name('admin.products.show');
        Route::get('/products/{id}/edit', [App\Http\Controllers\admin\ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{id}', [App\Http\Controllers\admin\ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [App\Http\Controllers\admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
        Route::get('/products/{id}/history', [App\Http\Controllers\admin\ProductController::class, 'history'])->name('admin.products.history');
        
        // Transaction routes
        Route::get('/transactions', [AdminDashboardController::class, 'transactions'])->name('admin.transactions');
        Route::get('/transactions/{id}', [AdminDashboardController::class, 'transactionDetail'])->name('admin.transaction.detail');
        Route::put('/transactions/{id}/status', [AdminDashboardController::class, 'updateTransactionStatus'])->name('admin.transaction.status.update');
        
        // Payment routes
        Route::post('/payments/{id}/approve', [PaymentController::class, 'approvePayment'])->name('admin.payment.approve');
        Route::post('/payments/{id}/reject', [PaymentController::class, 'rejectPayment'])->name('admin.payment.reject');
        Route::get('/payments/{id}', [PaymentController::class, 'showPayment'])->name('admin.payment.show');
        
        Route::get('/articles', [AdminDashboardController::class, 'articles'])->name('admin.articles');
        
        // Product Distribution Visualization
        Route::get('/product-distribution', [AdminDashboardController::class, 'productDistribution'])->name('admin.product.distribution');
        
        // Admin Logout
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
}); 
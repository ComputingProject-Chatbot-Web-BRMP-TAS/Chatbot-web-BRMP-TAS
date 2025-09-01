<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminTransactionController;
use App\Http\Controllers\admin\ComplaintController;
use App\Http\Controllers\admin\ArticleController;

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
        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
        Route::get('/transactions/{id}', [AdminTransactionController::class, 'show'])->name('admin.transactions.show');
        Route::put('/transactions/{id}/status', [AdminTransactionController::class, 'updateTransactionStatus'])->name('admin.transactions.status.update');
        Route::get('/transactions/{id}/billing', [AdminTransactionController::class, 'showBillingForm'])->name('admin.transactions.billing.form');
        Route::post('/transactions/{id}/billing', [AdminTransactionController::class, 'storeBilling'])->name('admin.transactions.billing.store');

        // Payment routes
        Route::post('/payments/{id}/approve', [AdminTransactionController::class, 'approvePayment'])->name('admin.transactions.payment.approve');
        Route::post('/payments/{id}/reject', [AdminTransactionController::class, 'rejectPayment'])->name('admin.transactions.payment.reject');

        // Nomor Resi routes
        Route::put('/transactions/{id}/resi', [AdminTransactionController::class, 'updateResi'])->name('admin.transactions.resi.update');
        
        // Article resource routes
        Route::resource('/articles', ArticleController::class)->names([
            'index' => 'admin.articles.index',
            'create' => 'admin.articles.create',
            'store' => 'admin.articles.store',
            'edit' => 'admin.articles.edit',
            'update' => 'admin.articles.update',
            'destroy' => 'admin.articles.destroy',
            'show' => 'admin.articles.show',
        ]);
        
        // Product Distribution Visualization
        Route::get('/product-distribution', [AdminDashboardController::class, 'productDistribution'])->name('admin.product.distribution');
        
        // Admin Logout
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        //Invoice
        Route::get('/transactions/{id}/invoice', [AdminTransactionController::class, 'viewInvoice'])->name('admin.transactions.invoice.view');
        Route::get('/transactions/{id}/invoice/download', [AdminTransactionController::class, 'downloadInvoice'])->name('admin.transactions.invoice.download');
    });
});
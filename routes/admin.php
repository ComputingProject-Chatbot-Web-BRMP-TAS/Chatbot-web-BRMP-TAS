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
        Route::get('/products', [AdminDashboardController::class, 'products'])->name('admin.products');
        Route::get('/transactions', [AdminDashboardController::class, 'transactions'])->name('admin.transactions');
        Route::get('/articles', [AdminDashboardController::class, 'articles'])->name('admin.articles');
        
        // Admin Logout
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
}); 
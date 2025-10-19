<?php

// =====================
// Import & Dependency
// =====================
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customer\DebugController;
use App\Http\Controllers\customer\ArticleController;
use App\Http\Controllers\customer\ProductController;
use App\Http\Controllers\ChatbotController;

// =====================
// INCLUDE ROLE-BASED ROUTES
// =====================
require __DIR__.'/guest.php';
require __DIR__.'/customer.php';
require __DIR__.'/admin.php';

// =====================
// DEBUG & DEV TOOLS (Development Only)
// =====================
if (app()->environment('local')) {
    Route::get('/debug/transactions', [DebugController::class, 'transactions']);
    Route::get('/debug/transaction-items', [DebugController::class, 'transactionItems']);
    Route::get('/debug/payments', [DebugController::class, 'payments']);
}

// =====================
// ARTICLE ROUTES
// =====================
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{id}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

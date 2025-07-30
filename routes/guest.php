<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customer\ProductController;
use App\Http\Controllers\customer\ArticleController;
use App\Http\Controllers\customer\AuthController as CustomerAuthController;

// =====================
// PUBLIC ROUTES (Semua User Bisa Akses)
// =====================
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/load-more-products', [ProductController::class, 'loadMore'])->name('load.more.products');
Route::get('/reset-products-session', [ProductController::class, 'resetSession'])->name('reset.products.session');
Route::get('/produk/{product_id}', [ProductController::class, 'detail'])->name('produk.detail');
Route::get('/produk-baru', [ProductController::class, 'baru'])->name('produk.baru');
Route::get('/kategori/{kategori}', [ProductController::class, 'kategori']);
Route::get('/artikel', [ArticleController::class, 'index'])->name('article');

// Public Auth (Login/Register)
Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.post');
Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.post'); 
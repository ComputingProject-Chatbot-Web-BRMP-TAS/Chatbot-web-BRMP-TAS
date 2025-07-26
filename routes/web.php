<?php

// =====================
// Import & Dependency
// =====================
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use App\Models\Product;
use App\Models\PlantTypes;
use App\Http\Controllers\customer\AddressController;
use App\Http\Controllers\customer\CartController;
use App\Http\Controllers\customer\PaymentController;
use App\Http\Controllers\customer\CheckoutController;
use App\Http\Controllers\customer\ComplaintController;
use App\Http\Controllers\customer\AuthController as CustomerAuthController;
use App\Http\Controllers\customer\TransactionController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\customer\ProfileController;
use App\Http\Controllers\customer\ProductController;
use App\Http\Controllers\customer\ArticleController;
use App\Http\Controllers\customer\DebugController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\customer\EmailVerificationController;

// =====================
// Umum & Landing Page
// =====================
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/load-more-products', [ProductController::class, 'loadMore'])->name('load.more.products');
Route::get('/reset-products-session', [ProductController::class, 'resetSession'])->name('reset.products.session');
Route::get('/produk/{product_id}', [ProductController::class, 'detail'])->name('produk.detail');
Route::get('/produk-baru', [ProductController::class, 'baru'])->name('produk.baru');
Route::get('/kategori/{kategori}', [ProductController::class, 'kategori']);
Route::get('/artikel', [ArticleController::class, 'index'])->name('article');

// =====================
// Customer Auth & Profile
// =====================
Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.post');
Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
Route::get('/profile', [ProfileController::class, 'show'])->middleware(['auth', 'verified'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/upload-foto', [ProfileController::class, 'uploadFoto'])->middleware('auth')->name('profile.upload_foto');
Route::post('/profile/send-otp', [ProfileController::class, 'sendOtp'])->middleware('auth')->name('profile.send_otp');
Route::post('/profile/verify-phone', [ProfileController::class, 'verifyPhone'])->middleware('auth')->name('profile.verify_phone');
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->middleware('auth')->name('profile.change_password');

// =====================
// Customer Cart, Checkout, Payment, Transaksi
// =====================
Route::get('/cart', [CartController::class, 'show'])->name('cart');
Route::middleware('auth')->group(function () {
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/primary', [AddressController::class, 'setPrimary'])->name('addresses.setPrimary');
    Route::patch('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::post('/cart/add/{produk}', [CartController::class, 'addToCart'])->name('cart.add');
});
Route::delete('/cart/delete/{cart_item}', [CartController::class, 'deleteItem'])->name('cart.delete')->middleware('auth');
Route::post('/cart/update-qty/{cart_item}', [CartController::class, 'updateQuantity'])->name('cart.update_qty')->middleware('auth');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::post('/checkout/next', [CheckoutController::class, 'next'])->name('checkout.next');
Route::post('/checkout/set-address/{addressId}', [CheckoutController::class, 'setAddress'])->name('checkout.set_address');
Route::post('/payment/start', [PaymentController::class, 'start'])->name('payment.start');
Route::get('/payment', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/upload-proof', [PaymentController::class, 'uploadProof'])->name('payment.upload_proof');
Route::get('/transaksi', [TransactionController::class, 'index'])->middleware('auth')->name('transaksi');
Route::get('/transaksi/{id}', [TransactionController::class, 'detail'])->middleware('auth')->name('transaksi.detail');

// =====================
// Komplain (Customer & Admin)
// =====================
Route::get('/komplain', [ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/komplain', [ComplaintController::class, 'store'])->name('complaint.store');
Route::get('/ADMIN-BRMP-TAS/komplain', [ComplaintController::class, 'index'])->middleware('admin')->name('complaint.index');
Route::get('/ADMIN-BRMP-TAS/komplain/{id}', [ComplaintController::class, 'show'])->middleware('admin')->name('complaint.show');

// =====================
// Admin Auth & Dashboard
// =====================
Route::get('/ADMIN-BRMP-TAS/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/ADMIN-BRMP-TAS/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/ADMIN-BRMP-TAS/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::get('/ADMIN-BRMP-TAS/dashboard', [AdminDashboardController::class, 'index'])->middleware('admin')->name('admin.dashboard');

// =====================
// Email Verification
// =====================
Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// =====================
// Debug & Dev Tools
// =====================
Route::get('/debug/transactions', [DebugController::class, 'transactions']);
Route::get('/debug/transaction-items', [DebugController::class, 'transactionItems']);
Route::get('/debug/payments', [DebugController::class, 'payments']);

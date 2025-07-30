<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customer\ProfileController;
use App\Http\Controllers\customer\AddressController;
use App\Http\Controllers\customer\CartController;
use App\Http\Controllers\customer\CheckoutController;
use App\Http\Controllers\customer\PaymentController;
use App\Http\Controllers\customer\TransactionController;
use App\Http\Controllers\customer\AuthController as CustomerAuthController;
use App\Http\Controllers\customer\EmailVerificationController;
use App\Http\Controllers\customer\ComplaintController;

// =====================
// CUSTOMER ROUTES (Authenticated Users)
// =====================
Route::group(['middleware' => 'auth'], function () {
    // Customer Profile
    Route::get('/profile', [ProfileController::class, 'show'])->middleware('verified')->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-foto', [ProfileController::class, 'uploadFoto'])->name('profile.upload_foto');
    Route::post('/profile/send-otp', [ProfileController::class, 'sendOtp'])->name('profile.send_otp');
    Route::post('/profile/verify-phone', [ProfileController::class, 'verifyPhone'])->name('profile.verify_phone');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change_password');
    
    // Customer Addresses
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/primary', [AddressController::class, 'setPrimary'])->name('addresses.setPrimary');
    Route::patch('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    
    // Customer Cart (View & Operations)
    Route::get('/cart', [CartController::class, 'show'])->name('cart');
    Route::post('/cart/add/{produk}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/delete/{cart_item}', [CartController::class, 'deleteItem'])->name('cart.delete');
    Route::post('/cart/update-qty/{cart_item}', [CartController::class, 'updateQuantity'])->name('cart.update_qty');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    
    // Customer Complaint
    Route::get('/komplain', [ComplaintController::class, 'create'])->name('complaint.create');
    Route::post('/komplain', [ComplaintController::class, 'store'])->name('complaint.store');
    
    // Customer Checkout & Payment
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/checkout/next', [CheckoutController::class, 'next'])->name('checkout.next');
    Route::post('/checkout/set-address/{addressId}', [CheckoutController::class, 'setAddress'])->name('checkout.set_address');
    Route::post('/payment/start', [PaymentController::class, 'start'])->name('payment.start');
    Route::get('/payment', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/upload-proof', [PaymentController::class, 'uploadProof'])->name('payment.upload_proof');
    
    // Customer Transactions
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi');
    Route::get('/transaksi/{id}', [TransactionController::class, 'detail'])->name('transaksi.detail');
    
    // Customer Logout
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
    
    // Email Verification
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
}); 
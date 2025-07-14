<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    $products = Product::all();
    return view('home', compact('products'));
});

Route::get('/register', function () {
    return view('auth.signup');
})->name('register');

Route::get('/login', function () {
    return view('auth.signin');
})->name('login');

Route::get('/cart', function () {
    if (!Auth::check()) return redirect()->route('login');
    $user = Auth::user();
    $cart = \App\Models\Cart::where('user_id', $user->id)->first();
    $items = $cart ? $cart->cartItems()->with('product')->get() : collect();
    $total = $items->sum(function($item) { return $item->kuantitas * $item->harga_satuan; });
    return view('cart', compact('items', 'total'));
})->name('cart');

Route::get('/produk/{id}', function ($id) {
    $product = \App\Models\Product::findOrFail($id);
    return view('produk.detail', compact('product'));
})->name('produk.detail');

Route::get('/produk-baru', function () {
    return view('produk_baru');
})->name('produk.baru');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required',
        'password' => 'required|min:4|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
    ]);

    // Log the user in after registration
    Auth::login($user);

    // Redirect to the email verification notice page
    return redirect()->route('verification.notice')->with('success', 'Akun berhasil dibuat. Silakan verifikasi email Anda!');
})->name('register.post');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        return redirect('/')->with('success', 'Berhasil login!');
    }

    return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
})->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('success', 'Berhasil logout!');
})->name('logout');

// Email verification notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Email verification handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/'); // or wherever you want after verification
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/profile', function () {
    if (!Auth::check()) return redirect('/login');
    return view('profile');
})->middleware(['auth', 'verified'])->name('profile');

Route::post('/profile/update', function (Request $request) {
    $user = Auth::user();
    $data = $request->only(['name', 'phone', 'gender', 'email']);
    // Gabungkan input tanggal lahir jika ada
    if ($request->filled(['birth_date_day', 'birth_date_month', 'birth_date_year'])) {
        $day = str_pad($request->birth_date_day, 2, '0', STR_PAD_LEFT);
        $month = str_pad($request->birth_date_month, 2, '0', STR_PAD_LEFT);
        $year = $request->birth_date_year;
        $data['birth_date'] = "$year-$month-$day";
    }
    $user->update($data);
    return back()->with('success', 'Profil berhasil diperbarui!');
})->name('profile.update');

Route::post('/profile/upload-foto', function (\Illuminate\Http\Request $request) {
    $user = Auth::user();
    $request->validate([
        'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:10240',
    ]);
    $file = $request->file('foto_profil');
    $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
    $path = $file->storeAs('public/foto_profil', $filename);
    $user->foto_profil = $filename;
    $user->save();
    return redirect()->route('profile')->with('success', 'Foto profil berhasil diupload!');
})->name('profile.upload_foto')->middleware('auth');

Route::get('/kategori/tumbuhan', function() {
    return view('kategori_tumbuhan');
});
Route::get('/kategori/rempah', function() {
    return view('kategori_rempah');
});
Route::get('/kategori/buah', function() {
    return view('kategori_buah');
});
Route::get('/kategori/sayuran', function() {
    return view('kategori_sayuran');
});
Route::get('/kategori/bunga', function() {
    return view('kategori_bunga');
});

Route::middleware('auth')->group(function () {
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/primary', [AddressController::class, 'setPrimary'])->name('addresses.setPrimary');
    Route::patch('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::post('/cart/add/{produk}', [CartController::class, 'addToCart'])->name('cart.add');
});

Route::post('/payment/start', [\App\Http\Controllers\PaymentController::class, 'start'])->name('payment.start');
Route::get('/payment', [PaymentController::class, 'show'])->name('payment.show');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::post('/checkout/next', [CheckoutController::class, 'next'])->name('checkout.next');
Route::post('/checkout/set-address/{addressId}', [CheckoutController::class, 'setAddress'])->name('checkout.set_address');

Route::get('/artikel', function () {
    return view('article');
})->name('article');

Route::delete('/cart/delete/{cart_item}', function($cart_item) {
    $item = \App\Models\CartItem::findOrFail($cart_item);
    $item->delete();
    return back()->with('success', 'Item berhasil dihapus dari keranjang!');
})->name('cart.delete')->middleware('auth');

Route::post('/cart/update-qty/{cart_item}', function(\Illuminate\Http\Request $request, $cart_item) {
    $item = \App\Models\CartItem::findOrFail($cart_item);
    $qty = max(1, (int) $request->input('kuantitas', 1));
    $item->kuantitas = $qty;
    $item->save();
    return response()->json([
        'success' => true,
        'kuantitas' => $item->kuantitas,
        'subtotal' => number_format($item->harga_satuan * $item->kuantitas, 0, ',', '.')
    ]);
})->name('cart.update_qty')->middleware('auth');

Route::post('/cart/checkout', function(\Illuminate\Http\Request $request) {
    $checked = $request->input('checked_items', []);
    $items = \App\Models\CartItem::whereIn('cart_item_id', $checked)->with('product')->get();
    $total = $items->sum(function($item) { return $item->kuantitas * $item->harga_satuan; });
    // Simulasi: tampilkan halaman ringkasan checkout (atau redirect ke pembayaran, dsb)
    return view('cart', [
        'items' => $items,
        'total' => $total,
        'checkout_mode' => true
    ]);
})->name('cart.checkout')->middleware('auth');

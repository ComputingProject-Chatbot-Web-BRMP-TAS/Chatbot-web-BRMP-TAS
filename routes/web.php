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

Route::get('/', function (Request $request) {
    $q = $request->input('q');
    if ($q) {
        // Flexible search: split q into words, each word must be in nama or deskripsi
        $keywords = preg_split('/\s+/', trim($q));
        $products = Product::where(function($query) use ($keywords) {
            foreach ($keywords as $word) {
                $query->where(function($sub) use ($word) {
                    $sub->where('nama', 'like', "%$word%")
                         ->orWhere('deskripsi', 'like', "%$word%")
                         ;
                });
            }
        })->get();
        // Reset session ketika melakukan pencarian
        session()->forget('displayed_products');
    } else {
        // Reset session dan tampilkan 10 produk baru secara acak
        session()->forget('displayed_products');
        // Tampilkan 10produk secara acak untuk section Produk Pilihan
        $products = Product::inRandomOrder()->take(10)->get();
        // Simpan ID produk yang sudah ditampilkan ke session
        session(['displayed_products' => $products->pluck('produk_id')->toArray()]);
    }
    $latestProducts = Product::orderBy('produk_id', 'desc')->take(5)->pluck('produk_id')->toArray();
    return view('home', compact('products', 'q', 'latestProducts'));
});

// Route untuk load more produk
Route::get('/load-more-products', function (Request $request) {
    $offset = $request->input('offset', 0);
    $limit = 10;

    // Ambil produk yang sudah ditampilkan dari session
    $displayedProducts = session('displayed_products', []);

    // Ambil produk yang belum ditampilkan
    $products = Product::whereNotIn('produk_id', $displayedProducts)
                      ->inRandomOrder()
                      ->take($limit)
                      ->get();

    // Update session dengan produk yang baru ditampilkan
    $newDisplayedProducts = array_merge($displayedProducts, $products->pluck('produk_id')->toArray());
    session(['displayed_products' => $newDisplayedProducts]);

    $totalProducts = Product::count();

    $html = '';
    foreach ($products as $produk) {
        $html .= view('partials.product-card', compact('produk'))->render();
    }

    return response()->json([
        'html' => $html,
        'hasMore' => count($newDisplayedProducts) < $totalProducts,
        'totalLoaded' => count($newDisplayedProducts),
        'totalProducts' => $totalProducts
    ]);
})->name('load.more.products');

// Route untuk reset session produk yang ditampilkan
Route::get('/reset-products-session', function () {
    session()->forget('displayed_products');
    return response()->json(['success' => true]);
})->name('reset.products.session');

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

Route::get('/produk/{produk_id}', function ($produk_id) {
    $product = \App\Models\Product::findOrFail($produk_id);
    $latestProducts = Product::orderBy('produk_id', 'desc')->take(5)->pluck('produk_id')->toArray();
    return view('produk.detail', compact('product', 'latestProducts'));
})->name('produk.detail');

Route::get('/produk-baru', function () {
    $products = Product::orderBy('produk_id', 'desc')->take(5)->get();
    $latestProducts = Product::orderBy('produk_id', 'desc')->take(5)->pluck('produk_id')->toArray();
    return view('produk_baru', compact('products', 'latestProducts'));
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
    // Jika input datepicker (tanggal_lahir) ada, gunakan itu
    if ($request->filled('tanggal_lahir')) {
        $data['birth_date'] = $request->input('tanggal_lahir');
    } else if ($request->filled(['birth_date_day', 'birth_date_month', 'birth_date_year'])) {
        $day = str_pad($request->birth_date_day, 2, '0', STR_PAD_LEFT);
        $month = str_pad($request->birth_date_month, 2, '0', STR_PAD_LEFT);
        $year = $request->birth_date_year;
        $data['birth_date'] = "$year-$month-$day";
    }
    // Jika phone berubah, reset verifikasi
    if (isset($data['phone']) && $data['phone'] !== $user->phone) {
        $data['phone_verified_at'] = null;
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
    $products = Product::where('jenis_kategori', 'Tumbuhan')->get();
    $latestProducts = Product::orderBy('produk_id', 'desc')->take(5)->pluck('produk_id')->toArray();
    return view('kategori_tumbuhan', compact('products', 'latestProducts'));
});
Route::get('/kategori/rempah', function() {
    $products = Product::where('jenis_kategori', 'Rempah-Rempah/Herbal')->get();
    $latestProducts = Product::orderBy('produk_id', 'desc')->take(5)->pluck('produk_id')->toArray();
    return view('kategori_rempah', compact('products', 'latestProducts'));
});
Route::get('/kategori/buah', function() {
    $products = Product::where('jenis_kategori', 'Buah-Buahan')->get();
    $latestProducts = Product::orderBy('produk_id', 'desc')->take(5)->pluck('produk_id')->toArray();
    return view('kategori_buah', compact('products', 'latestProducts'));
});
Route::get('/kategori/sayuran', function() {
    $products = Product::where('jenis_kategori', 'Sayuran')->get();
    $latestProducts = Product::orderBy('produk_id', 'desc')->take(5)->pluck('produk_id')->toArray();
    return view('kategori_sayuran', compact('products', 'latestProducts'));
});
Route::get('/kategori/bunga', function() {
    $products = Product::where('jenis_kategori', 'Bunga')->get();
    $latestProducts = Product::orderBy('produk_id', 'desc')->take(5)->pluck('produk_id')->toArray();
    return view('kategori_bunga', compact('products', 'latestProducts'));
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
Route::post('/payment/upload-proof', [PaymentController::class, 'uploadProof'])->name('payment.upload_proof');

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

// Route untuk mengirim OTP ke nomor HP
Route::post('/profile/send-otp', function (\Illuminate\Http\Request $request) {
    $user = Auth::user();
    $otp = rand(100000, 999999);
    session(['otp_phone' => $otp, 'otp_phone_number' => $user->phone]);
    // Simulasi kirim OTP via SMS (implementasi asli: gunakan layanan SMS gateway)
    \Log::info("OTP untuk verifikasi nomor HP {$user->phone}: $otp");
    // Tambahan debug manual:
    file_put_contents(storage_path('logs/otp_debug.txt'), "OTP: $otp untuk {$user->phone} pada ".date('Y-m-d H:i:s')."\n", FILE_APPEND);
    return back()->with('success', 'Kode OTP telah dikirim ke nomor HP Anda.');
})->middleware('auth')->name('profile.send_otp');

// Route untuk verifikasi OTP
Route::post('/profile/verify-phone', function (\Illuminate\Http\Request $request) {
    $user = Auth::user();
    $otp = $request->input('otp_code');
    $sessionOtp = session('otp_phone');
    $sessionPhone = session('otp_phone_number');
    if ($otp && $sessionOtp && $user->phone === $sessionPhone && $otp == $sessionOtp) {
        $user->phone_verified_at = now();
        $user->save();
        session()->forget(['otp_phone', 'otp_phone_number']);
        return back()->with('success', 'Nomor HP berhasil diverifikasi!');
    } else {
        return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kadaluarsa.']);
    }
})->middleware('auth')->name('profile.verify_phone');

// Ganti Password
Route::post('/profile/change-password', function (\Illuminate\Http\Request $request) {
    $user = Auth::user();
    $request->validate([
        'old_password' => 'required',
        'new_password' => [
            'required',
            'min:8',
            'regex:/[A-Z]/', // huruf besar
            'regex:/[a-z]/', // huruf kecil
            'regex:/[0-9]/', // angka
            'regex:/[^A-Za-z0-9]/', // simbol
            'confirmed',
        ],
    ], [
        'new_password.min' => 'Password minimal 8 karakter.',
        'new_password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
        'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);
    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['old_password' => 'Password lama salah.'])->withInput();
    }
    $user->password = Hash::make($request->new_password);
    $user->save();
    return back()->with('success', 'Password berhasil diubah!');
})->middleware('auth')->name('profile.change_password');

Route::get('/transaksi', [\App\Http\Controllers\TransactionController::class, 'index'])->middleware('auth')->name('transaksi');
Route::get('/transaksi/{id}', [\App\Http\Controllers\TransactionController::class, 'detail'])->middleware('auth')->name('transaksi.detail');

Route::get('/debug/transactions', function() {
    $transactions = \App\Models\Transaction::with(['transactionItems.product', 'payments'])->get();
    return response()->json($transactions);
});
Route::get('/debug/transaction-items', function() {
    return response()->json(\App\Models\TransactionItem::with('product')->get());
});
Route::get('/debug/payments', function() {
    return response()->json(\App\Models\Payment::all());
});

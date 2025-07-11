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
    $produk = Product::findOrFail($id);
    return view('produk.detail', ['produk' => $produk]);
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

    // Optionally log the user in after registration
    // Auth::login($user);

    return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login!');
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

Route::get('/profile', function () {
    if (!Auth::check()) return redirect('/login');
    return view('profile');
})->name('profile');

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

Route::get('/artikel', function () {
    return view('article');
})->name('article');

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    return view('home');
});

Route::get('/register', function () {
    return view('auth.signup');
})->name('register');

Route::get('/login', function () {
    return view('auth.signin');
})->name('login');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/produk/{id}', function ($id) {
    $produkList = [
        1 => [
            'nama' => 'Benih Cabai Rawit',
            'harga' => 15000,
            'deskripsi' => 'Isi 50 butir, cocok untuk pekarangan rumah.',
            'kategori' => 'Benih',
            'kondisi' => 'Baru',
            'style' => 'Premium',
            'stok' => 100,
            'img' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/7/6/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg',
        ],
        2 => [
            'nama' => 'Benih Tomat',
            'harga' => 12000,
            'deskripsi' => 'Tahan penyakit, hasil melimpah.',
            'kategori' => 'Benih',
            'kondisi' => 'Baru',
            'style' => 'Premium',
            'stok' => 80,
            'img' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/12/1/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg',
        ],
        3 => [
            'nama' => 'Benih Kangkung',
            'harga' => 8000,
            'deskripsi' => 'Cepat panen, cocok untuk hidroponik.',
            'kategori' => 'Benih',
            'kondisi' => 'Baru',
            'style' => 'Premium',
            'stok' => 120,
            'img' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2022/10/10/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg',
        ],
        4 => [
            'nama' => 'Benih Bayam',
            'harga' => 7000,
            'deskripsi' => 'Bayam hijau segar, mudah tumbuh.',
            'kategori' => 'Benih',
            'kondisi' => 'Baru',
            'style' => 'Premium',
            'stok' => 90,
            'img' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/1/15/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg',
        ],
        5 => [
            'nama' => 'Benih Wortel',
            'harga' => 10000,
            'deskripsi' => 'Wortel oranye, cocok untuk dataran tinggi.',
            'kategori' => 'Benih',
            'kondisi' => 'Baru',
            'style' => 'Premium',
            'stok' => 60,
            'img' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/3/20/2e2e2e2e-2e2e-2e2e-2e2e-2e2e2e2e2e2e.jpg',
        ],
    ];
    $produk = $produkList[$id] ?? null;
    if (!$produk) abort(404);
    return view('produk.detail', ['produk' => $produk, 'id' => $id]);
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

Route::get('/addresses', function () {
    if (!Auth::check()) return redirect('/login');
    return view('addresses');
})->name('addresses');

Route::get('/artikel', function () {
    return view('article');
})->name('article');

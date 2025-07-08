<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

/* Route::get('/', function () {
    return redirect()->route('register');
});

Route::get('/register', function () {
    return view('auth.signup');
})->name('register');

Route::get('/login', function () {
    return view('auth.signin');
})->name('login');
*/

Route::get('/register', function () {
    return view('auth.signup');
})->name('register');

Route::get('/login', function () {
    return view('auth.signin');
})->name('login');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/produk/{nama}', function ($nama) {
    // Data dummy produk
    $produkList = [
        'hp' => [
            'nama' => 'hp',
            'harga' => 123213,
            'deskripsi' => 'Handphone canggih, kondisi baru dengan tag.',
            'kategori' => 'Elektronik',
            'kondisi' => 'Baru',
            'style' => 'Modern',
            'gambar' => null,
        ],
        'buku-cerita' => [
            'nama' => 'buku cerita',
            'harga' => 10000,
            'deskripsi' => 'Buku cerita anak, bekas tapi masih bagus.',
            'kategori' => 'Buku',
            'kondisi' => 'Bekas',
            'style' => 'Klasik',
            'gambar' => null,
        ],
        'jembatan' => [
            'nama' => 'jembatan',
            'harga' => 30000,
            'deskripsi' => 'Miniatur jembatan, baru dengan tag.',
            'kategori' => 'Mainan',
            'kondisi' => 'Baru',
            'style' => 'Unik',
            'gambar' => null,
        ],
        'ikan-mujaer' => [
            'nama' => 'ikan mujaer',
            'harga' => 1222222222222,
            'deskripsi' => 'Ikan mujaer segar, baru.',
            'kategori' => 'Hewan',
            'kondisi' => 'Baru',
            'style' => 'Natural',
            'gambar' => null,
        ],
        'ayam-jagoo' => [
            'nama' => 'ayam jagoo',
            'harga' => 8888888888888,
            'deskripsi' => 'Ayam jago, bekas seperti baru.',
            'kategori' => 'Hewan',
            'kondisi' => 'Bekas seperti baru',
            'style' => 'Tradisional',
            'gambar' => null,
        ],
    ];
    $key = str_replace(' ', '-', strtolower($nama));
    $produk = $produkList[$key] ?? null;
    if (!$produk) abort(404);
    return view('produk.detail', compact('produk'));
})->name('produk.detail');

Route::get('/dummy-register', function () {
    return view('auth.dummy_register');
})->name('dummy.register');

Route::post('/dummy-register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'password' => 'required|min:3',
    ]);
    $users = session('dummy_users', []);
    foreach ($users as $user) {
        if ($user['name'] === $request->name) {
            return back()->withErrors(['name' => 'Nama sudah terdaftar!']);
        }
    }
    $users[] = [
        'name' => $request->name,
        'password' => $request->password,
    ];
    session(['dummy_users' => $users]);
    return redirect()->route('dummy.login')->with('success', 'Berhasil daftar! Silakan login.');
});

Route::get('/dummy-login', function () {
    return view('auth.dummy_login');
})->name('dummy.login');

Route::post('/dummy-login', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'password' => 'required',
    ]);
    $users = session('dummy_users', []);
    foreach ($users as $user) {
        if ($user['name'] === $request->name && $user['password'] === $request->password) {
            session(['dummy_user' => ['name' => $user['name']]]);
            return redirect('/');
        }
    }
    return back()->withErrors(['name' => 'Nama atau password salah!']);
});

Route::post('/dummy-logout', function (Request $request) {
    $request->session()->forget('dummy_user');
    return redirect('/');
})->name('dummy.logout');
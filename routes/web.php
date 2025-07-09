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

Route::get('/produk/{id}', function ($id) {
    return view('produk.detail', ['id' => $id]);
})->name('produk.detail');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'password' => 'required|min:4',
    ]);
    $users = session('users', []);
    $users[$request->email] = [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => $request->password,
    ];
    session(['users' => $users]);
    return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login!');
})->name('register.post');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    $users = session('users', []);
    if (isset($users[$request->email]) && $users[$request->email]['password'] === $request->password) {
        session(['user' => $users[$request->email]]);
        return redirect('/')->with('success', 'Berhasil login!');
    }
    return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
})->name('login.post');

Route::post('/logout', function () {
    session()->forget('user');
    return redirect('/login')->with('success', 'Berhasil logout!');
})->name('logout');

Route::get('/profile', function () {
    if (!session('user')) return redirect('/login');
    return view('profile');
})->name('profile');

Route::get('/profile/edit', function () {
    if (!session('user')) return redirect('/login');
    return view('profile_edit');
})->name('profile.edit');

Route::post('/profile/edit', function (Request $request) {
    if (!session('user')) return redirect('/login');
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
    ]);
    $user = session('user');
    $users = session('users', []);
    // Hapus user lama jika email berubah
    if ($user['email'] !== $request->email) {
        unset($users[$user['email']]);
    }
    $users[$request->email] = [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => $user['password'],
    ];
    session(['users' => $users, 'user' => $users[$request->email]]);
    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
})->name('profile.edit');

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

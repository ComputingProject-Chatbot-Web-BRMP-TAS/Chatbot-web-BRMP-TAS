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

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'username' => 'required|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required',
        'password' => 'required|min:4|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
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

Route::get('/profile/edit', function () {
    if (!Auth::check()) return redirect('/login');
    return view('profile_edit');
})->name('profile.edit');

Route::post('/profile/edit', function (Request $request) {
    if (!Auth::check()) return redirect('/login');
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'phone' => 'required',
    ]);
    $user = Auth::user();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->save();
    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
})->name('profile.edit');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/produk/{id}', function ($id) {
    return view('produk.detail', ['id' => $id]);
})->name('produk.detail');

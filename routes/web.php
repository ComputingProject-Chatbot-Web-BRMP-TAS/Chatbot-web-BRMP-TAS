<?php

use Illuminate\Support\Facades\Route;
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
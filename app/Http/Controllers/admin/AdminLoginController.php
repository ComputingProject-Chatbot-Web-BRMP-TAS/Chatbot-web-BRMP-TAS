<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Hanya user dengan role admin yang bisa login di sini
        $admin = \App\Models\User::where('email', $request->email)->where('role', 'admin')->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::login($admin);
            return redirect('/ADMIN-BRMP-TAS')->with('success', 'Berhasil login sebagai admin!');
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/ADMIN-BRMP-TAS/login')->with('success', 'Berhasil logout!');
    }
} 
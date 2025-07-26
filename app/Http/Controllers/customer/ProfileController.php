<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        if (!Auth::check()) return redirect('/login');
        return view('customer.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->only(['name', 'phone', 'gender', 'email']);
        if ($request->filled('tanggal_lahir')) {
            $data['birth_date'] = $request->input('tanggal_lahir');
        } else if ($request->filled(['birth_date_day', 'birth_date_month', 'birth_date_year'])) {
            $day = str_pad($request->birth_date_day, 2, '0', STR_PAD_LEFT);
            $month = str_pad($request->birth_date_month, 2, '0', STR_PAD_LEFT);
            $year = $request->birth_date_year;
            $data['birth_date'] = "$year-$month-$day";
        }
        if (isset($data['phone']) && $data['phone'] !== $user->phone) {
            $data['phone_verified_at'] = null;
        }
        $user->update($data);
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function uploadFoto(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);
        $file = $request->file('foto_profil');
        $filename = 'user_' . $user->user_id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/foto_profil', $filename);
        $user->foto_profil = $filename;
        $user->save();
        return redirect()->route('profile')->with('success', 'Foto profil berhasil diupload!');
    }

    public function sendOtp(Request $request)
    {
        $user = Auth::user();
        $otp = rand(100000, 999999);
        session(['otp_phone' => $otp, 'otp_phone_number' => $user->phone]);
        \Log::info("OTP untuk verifikasi nomor HP {$user->phone}: $otp");
        file_put_contents(storage_path('logs/otp_debug.txt'), "OTP: $otp untuk {$user->phone} pada ".date('Y-m-d H:i:s')."\n", FILE_APPEND);
        return back()->with('success', 'Kode OTP telah dikirim ke nomor HP Anda.');
    }

    public function verifyPhone(Request $request)
    {
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
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
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
    }
} 
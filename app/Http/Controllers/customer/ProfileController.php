<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function show()
    {
        if (!Auth::check()) return redirect('/login');
        return view('customer.profile');
    }

    public function update(Request $request)
    {
        try {
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

            $this->userService->updateProfile($user, $data);
            return back()->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    public function uploadFoto(Request $request)
    {
        try {
            $user = Auth::user();
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            ]);

            $this->userService->uploadProfilePicture($user, $request->file('profile_picture'));
            return redirect()->route('profile')->with('success', 'Foto profil berhasil diupload!');

        } catch (\Exception $e) {
            return redirect()->route('profile')->with('error', 'Gagal upload foto: ' . $e->getMessage());
        }
    }

    public function sendOtp(Request $request)
    {
        try {
            $user = Auth::user();
            $this->userService->sendPhoneOTP($user);
            return back()->with('success', 'Kode OTP telah dikirim ke nomor HP Anda.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim OTP: ' . $e->getMessage());
        }
    }

    public function verifyPhone(Request $request)
    {
        try {
            $user = Auth::user();
            $otp = $request->input('otp_code');
            
            $result = $this->userService->verifyPhone($user, $otp);
            
            if ($result) {
                return back()->with('success', 'Nomor HP berhasil diverifikasi!');
            } else {
                return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah kadaluarsa.']);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['otp_code' => $e->getMessage()]);
        }
    }

    public function changePassword(Request $request)
    {
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

        try {
            $user = Auth::user();
            $this->userService->changePassword(
                $user, 
                $request->old_password, 
                $request->new_password
            );
            
            return back()->with('success', 'Password berhasil diubah!');

        } catch (\Exception $e) {
            return back()->withErrors(['old_password' => $e->getMessage()])->withInput();
        }
    }
}

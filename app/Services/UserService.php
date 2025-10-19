<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * Update user profile with validation
     */
    public function updateProfile(User $user, array $data)
    {
        try {
            DB::beginTransaction();

            // Handle birth date formats
            if (isset($data['birth_date_day'], $data['birth_date_month'], $data['birth_date_year'])) {
                $day = str_pad($data['birth_date_day'], 2, '0', STR_PAD_LEFT);
                $month = str_pad($data['birth_date_month'], 2, '0', STR_PAD_LEFT);
                $year = $data['birth_date_year'];
                $data['birth_date'] = "$year-$month-$day";
                
                unset($data['birth_date_day'], $data['birth_date_month'], $data['birth_date_year']);
            }

            // Handle phone verification reset
            if (isset($data['phone']) && $data['phone'] !== $user->phone) {
                $data['phone_verified_at'] = null;
                
                Log::info('Phone number changed, verification reset', [
                    'user_id' => $user->user_id,
                    'old_phone' => $user->phone,
                    'new_phone' => $data['phone']
                ]);
            }

            // Only update allowed fields
            $allowedFields = ['name', 'phone', 'gender', 'email', 'birth_date', 'phone_verified_at'];
            $updateData = array_intersect_key($data, array_flip($allowedFields));

            $user->update($updateData);

            Log::info('User profile updated', [
                'user_id' => $user->user_id,
                'updated_fields' => array_keys($updateData)
            ]);

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update user profile', [
                'user_id' => $user->user_id ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Upload user profile picture
     */
    public function uploadProfilePicture(User $user, $file)
    {
        try {
            DB::beginTransaction();

            $oldPicture = $user->profile_picture;

            // Upload new picture
            $filename = 'user_' . $user->user_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_pictures', $filename);

            $user->update(['profile_picture' => $filename]);

            // Delete old picture
            if ($oldPicture && $oldPicture !== $filename) {
                Storage::delete('public/profile_pictures/' . $oldPicture);
            }

            Log::info('Profile picture uploaded', [
                'user_id' => $user->user_id,
                'filename' => $filename
            ]);

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete uploaded file if save failed
            if (isset($filename)) {
                Storage::delete('public/profile_pictures/' . $filename);
            }
            
            Log::error('Failed to upload profile picture', [
                'user_id' => $user->user_id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Change user password with validation
     */
    public function changePassword(User $user, string $oldPassword, string $newPassword)
    {
        try {
            // Verify old password
            if (!Hash::check($oldPassword, $user->password)) {
                throw new \Exception('Password lama salah.');
            }

            // Update password
            $user->update(['password' => Hash::make($newPassword)]);

            Log::info('Password changed', [
                'user_id' => $user->user_id
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to change password', [
                'user_id' => $user->user_id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Send OTP for phone verification
     */
    public function sendPhoneOTP(User $user)
    {
        try {
            $otp = rand(100000, 999999);
            
            // Store OTP in session (in production, use SMS service)
            session([
                'otp_phone' => $otp,
                'otp_phone_number' => $user->phone,
                'otp_expires_at' => now()->addMinutes(5)
            ]);

            // Log OTP generated (without sensitive data for production)
            Log::info('OTP generated for phone verification', [
                'user_id' => $user->user_id,
                'phone' => Str::mask($user->phone, '*', 3, -3),
                'expires_at' => now()->addMinutes(5)->toDateTimeString()
            ]);

            return $otp;

        } catch (\Exception $e) {
            Log::error('Failed to send OTP', [
                'user_id' => $user->user_id,
                'phone' => $user->phone ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Verify phone number with OTP
     */
    public function verifyPhone(User $user, string $otpCode)
    {
        try {
            $sessionOtp = session('otp_phone');
            $sessionPhone = session('otp_phone_number');
            $expiresAt = session('otp_expires_at');

            // Validate OTP
            if (!$sessionOtp || !$sessionPhone || !$expiresAt) {
                throw new \Exception('Kode OTP tidak ditemukan atau sudah kadaluarsa.');
            }

            if (now() > $expiresAt) {
                throw new \Exception('Kode OTP sudah kadaluarsa.');
            }

            if ($user->phone !== $sessionPhone) {
                throw new \Exception('Nomor HP tidak sesuai.');
            }

            if ($otpCode != $sessionOtp) {
                throw new \Exception('Kode OTP salah.');
            }

            // Verify phone
            $user->update(['phone_verified_at' => now()]);

            // Clear OTP session
            session()->forget(['otp_phone', 'otp_phone_number', 'otp_expires_at']);

            Log::info('Phone verified successfully', [
                'user_id' => $user->user_id,
                'phone' => $user->phone
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Phone verification failed', [
                'user_id' => $user->user_id,
                'phone' => $user->phone ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get user statistics for admin
     */
    public function getUserStatistics()
    {
        return [
            'total_users' => User::count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'phone_verified_users' => User::whereNotNull('phone_verified_at')->count(),
            'recent_registrations' => User::whereDate('created_at', '>=', now()->subDays(7))->count(),
            'active_users' => User::whereDate('updated_at', '>=', now()->subDays(30))->count(),
        ];
    }

    /**
     * Register new user
     */
    public function registerUser(array $data)
    {
        try {
            DB::beginTransaction();

            // Validate unique email
            $existingUser = User::where('email', $data['email'])->first();
            if ($existingUser) {
                throw new \Exception('Email sudah terdaftar.');
            }

            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'email_verified_at' => null,
                'phone_verified_at' => null,
            ]);

            Log::info('User registered', [
                'user_id' => $user->user_id,
                'email' => $user->email,
                'name' => $user->name
            ]);

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to register user', [
                'email' => $data['email'] ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('1234'),
                'phone' => null,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'role' => 'admin'
            ],
            [
                'name' => 'User',
                'email' => 'user@test.com',
                'password' => Hash::make('1234'),
                'phone'=> '0812345678',
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'role' => 'customer'
            ],
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    const ROLE_ADMIN = 'admin';
    const ROLE_CUSTOMER = 'customer';
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'birth_date',
        'profile_picture',
        'email_verified_at',
        'phone_verified_at',
        'role',
        'is_active',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'user_id');
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/profile_pictures/' . $this->profile_picture);
        }
        return asset('images/default-profile.png');
    }

    public function isPhoneVerified()
    {
        return !is_null($this->phone_verified_at);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }
}

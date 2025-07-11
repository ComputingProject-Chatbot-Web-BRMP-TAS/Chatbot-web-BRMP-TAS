<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'label', 'address', 'latitude', 'longitude', 'is_primary', 'note', 'recipient_name', 'recipient_phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

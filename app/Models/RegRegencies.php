<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegRegencies extends Model
{
    protected $table = 'reg_regencies';
    
    protected $fillable = [
        'id',
        'province_id',
        'name'
    ];

    public function province()
    {
        return $this->belongsTo(RegProvinces::class, 'province_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegProvinces extends Model
{
    protected $table = 'reg_provinces';
    
    protected $fillable = [
        'id',
        'name'
    ];

    public function regencies()
    {
        return $this->hasMany(RegRegencies::class, 'province_id', 'id');
    }
}

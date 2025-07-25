<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantTypes extends Model
{
    protected $table = 'plant_types';
    protected $primaryKey = 'plant_type_id';
    protected $fillable = [
        'plant_type_name',
        'comodity',
    ];

    public function products(){
        return $this->hasMany(Product::class, 'plant_type_id', 'plant_type_id');
    }
}

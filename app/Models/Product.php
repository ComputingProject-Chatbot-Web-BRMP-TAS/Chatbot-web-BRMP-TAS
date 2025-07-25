<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name',
        'plant_type_id',
        'description',
        'stock',
        'minimum_stock',
        'unit',
        'price_per_unit',
        'minimum_purchase',
        'image1',
        'image2',
        'image_certificate',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id', 'product_id');
    }

    public function plantType() {
        return $this->belongsTo(\App\Models\PlantTypes::class, 'plant_type_id', 'plant_type_id');
    }
}

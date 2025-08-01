<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'history_id';

    protected $table = 'product_histories';

    protected $fillable = [
        'product_id',
        'plant_type_name',
        'product_name',
        'description',
        'stock',
        'minimum_stock',
        'unit',
        'price_per_unit',
        'minimum_purchase',
        'image1',
        'image2',
        'image_certificate',
        'certificate_number',
        'certificate_class',
        'valid_from',
        'valid_until',
        'recorded_at',
    ];

    protected $casts = [
        'stock' => 'decimal:2',
        'minimum_stock' => 'decimal:2',
        'price_per_unit' => 'integer',
        'minimum_purchase' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'recorded_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
} 
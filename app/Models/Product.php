<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductHistory;

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
        'certificate_number',
        'certificate_class',
        'valid_from',
        'valid_until',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id', 'product_id');
    }

    public function plantType() {
        return $this->belongsTo(\App\Models\PlantTypes::class, 'plant_type_id', 'plant_type_id');
    }

    /**
     * Get all history records for this product.
     */
    public function histories()
    {
        return $this->hasMany(ProductHistory::class, 'product_id', 'product_id');
    }

    /**
     * Create a history record when product is created or updated.
     */
    protected static function booted()
    {
        static::created(function ($product) {
            $product->createHistoryRecord();
        });
        
        static::updated(function ($product) {
            $product->createHistoryRecord();
        });
    }

    /**
     * Create a history record with current product data.
     */
    public function createHistoryRecord()
    {
        try {
            // Create history record without timestamps
            $historyData = [
                'product_id' => $this->product_id,
                'plant_type_name' => $this->plantType->plant_type_name ?? '',
                'product_name' => $this->product_name,
                'description' => $this->description,
                'stock' => $this->stock,
                'minimum_stock' => $this->minimum_stock,
                'unit' => $this->unit,
                'price_per_unit' => $this->price_per_unit,
                'minimum_purchase' => $this->minimum_purchase,
                'image1' => $this->image1,
                'image2' => $this->image2,
                'image_certificate' => $this->image_certificate,
                'certificate_number' => $this->certificate_number,
                'certificate_class' => $this->certificate_class,
                'valid_from' => $this->valid_from,
                'valid_until' => $this->valid_until,
                'recorded_at' => now(),
            ];
            
            // Log the history creation attempt
            \Log::info('Creating product history', [
                'product_id' => $this->product_id,
                'product_name' => $this->product_name,
                'history_data' => $historyData
            ]);
            
            // Use insert to avoid timestamps completely
            $historyId = ProductHistory::insertGetId($historyData);
            $history = ProductHistory::find($historyId);
            
            \Log::info('Product history created successfully', [
                'history_id' => $history->history_id,
                'product_id' => $this->product_id
            ]);
            
            return $history;
            
        } catch (\Exception $e) {
            \Log::error('Failed to create product history', [
                'product_id' => $this->product_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get the latest history record.
     */
    public function latestHistory()
    {
        return $this->histories()->latest('recorded_at')->first();
    }

    /**
     * Get history records within a date range.
     */
    public function getHistoryByDateRange($startDate, $endDate)
    {
        return $this->histories()
            ->whereBetween('recorded_at', [$startDate, $endDate])
            ->orderBy('recorded_at', 'desc')
            ->get();
    }

    /**
     * Manually create a history record for testing.
     */
    public function createHistoryRecordManually()
    {
        return $this->createHistoryRecord();
    }
}

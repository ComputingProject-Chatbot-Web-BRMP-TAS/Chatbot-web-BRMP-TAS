<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\PlantTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Get products with filters (enhanced for admin)
     */
    public function getProducts(array $filters = [])
    {
        $query = Product::with(['plantType']);

        // Search functionality
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('certificate_number', 'like', "%{$search}%")
                  ->orWhere('certificate_class', 'like', "%{$search}%")
                  ->orWhereHas('plantType', function($plantQuery) use ($search) {
                      $plantQuery->where('plant_type_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by plant type
        if (isset($filters['plant_type_id']) && !empty($filters['plant_type_id'])) {
            $query->where('plant_type_id', $filters['plant_type_id']);
        }

        // Filter by stock status
        if (isset($filters['stock_status']) && !empty($filters['stock_status'])) {
            switch ($filters['stock_status']) {
                case 'available':
                    $query->whereRaw('stock > minimum_stock');
                    break;
                case 'low_stock':
                    $query->whereRaw('stock <= minimum_stock AND stock > 0');
                    break;
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
            }
        }

        // Filter by price range
        if (isset($filters['min_price'])) {
            $query->where('price_per_unit', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price_per_unit', '<=', $filters['max_price']);
        }

        // Filter by certificate
        if (isset($filters['has_certificate'])) {
            if ($filters['has_certificate'] == 'yes') {
                $query->whereNotNull('certificate_number');
            } elseif ($filters['has_certificate'] == 'no') {
                $query->whereNull('certificate_number');
            }
        }

        // Filter by availability
        if (isset($filters['available_only']) && $filters['available_only']) {
            $query->where('stock', '>', 0);
        }

        // Search by name or description (for customer view)
        if (isset($filters['search']) && !isset($filters['admin_search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort options
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $filters['per_page'] ?? 12;
        
        return $query->paginate($perPage);
    }

    /**
     * Create new product (enhanced for admin with multiple images)
     */
    public function createProduct(array $data, $image1File = null, $image2File = null, $imageCertificateFile = null)
    {
        try {
            DB::beginTransaction();

            // Handle image uploads
            if ($image1File) {
                $data['image1'] = $this->uploadImage($image1File, 'products');
            }
            if ($image2File) {
                $data['image2'] = $this->uploadImage($image2File, 'products');
            }
            if ($imageCertificateFile) {
                $data['image_certificate'] = $this->uploadImage($imageCertificateFile, 'certificates');
            }

            // Generate slug
            $data['slug'] = $this->generateSlug($data['product_name']);

            $product = Product::create($data);

            // Log product creation
            $this->logProductHistory($product, 'created', 'Product created');

            DB::commit();
            return $product;

        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete uploaded images if product creation failed
            if (isset($data['image1'])) {
                Storage::disk('public')->delete($data['image1']);
            }
            if (isset($data['image2'])) {
                Storage::disk('public')->delete($data['image2']);
            }
            if (isset($data['image_certificate'])) {
                Storage::disk('public')->delete($data['image_certificate']);
            }
            
            throw $e;
        }
    }

    /**
     * Upload product image with custom path
     */
    protected function uploadImage($imageFile, $folder = 'products')
    {
        $filename = time() . '_' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
        return $imageFile->storeAs($folder, $filename, 'public');
    }

    /**
     * Update product (enhanced for admin with multiple images)
     */
    public function updateProduct(Product $product, array $data, $image1File = null, $image2File = null, $imageCertificateFile = null)
    {
        try {
            DB::beginTransaction();

            $oldImage1 = $product->image1;
            $oldImage2 = $product->image2;
            $oldImageCertificate = $product->image_certificate;

            // Handle image uploads
            if ($image1File) {
                $data['image1'] = $this->uploadImage($image1File, 'products');
                // Delete old image
                if ($oldImage1) {
                    Storage::disk('public')->delete($oldImage1);
                }
            }
            
            if ($image2File) {
                $data['image2'] = $this->uploadImage($image2File, 'products');
                // Delete old image
                if ($oldImage2) {
                    Storage::disk('public')->delete($oldImage2);
                }
            }
            
            if ($imageCertificateFile) {
                $data['image_certificate'] = $this->uploadImage($imageCertificateFile, 'certificates');
                // Delete old image
                if ($oldImageCertificate) {
                    Storage::disk('public')->delete($oldImageCertificate);
                }
            }

            // Update slug if name changed
            if (isset($data['product_name']) && $data['product_name'] !== $product->product_name) {
                $data['slug'] = $this->generateSlug($data['product_name']);
            }

            $product->update($data);

            // Log product update
            $this->logProductHistory($product, 'updated', 'Product updated');

            DB::commit();
            return $product;

        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete new uploaded images if update failed
            if (isset($data['image1']) && $data['image1'] !== $oldImage1) {
                Storage::disk('public')->delete($data['image1']);
            }
            if (isset($data['image2']) && $data['image2'] !== $oldImage2) {
                Storage::disk('public')->delete($data['image2']);
            }
            if (isset($data['image_certificate']) && $data['image_certificate'] !== $oldImageCertificate) {
                Storage::disk('public')->delete($data['image_certificate']);
            }
            
            throw $e;
        }
    }

    /**
     * Delete product
     */
    public function deleteProduct(Product $product)
    {
        try {
            DB::beginTransaction();

            // Log product deletion before deleting
            $this->logProductHistory($product, 'deleted', 'Product deleted');

            // Delete image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update product stock
     */
    public function updateStock(Product $product, int $quantity, string $type = 'add', string $reason = null)
    {
        try {
            DB::beginTransaction();

            $oldStock = $product->stock;

            if ($type === 'add') {
                $product->stock += $quantity;
            } elseif ($type === 'subtract') {
                if ($product->stock < $quantity) {
                    throw new \Exception('Insufficient stock');
                }
                $product->stock -= $quantity;
            } else {
                throw new \Exception('Invalid stock update type');
            }

            $product->save();

            // Log stock change
            $message = "Stock {$type}: {$quantity}. From {$oldStock} to {$product->stock}";
            if ($reason) {
                $message .= ". Reason: {$reason}";
            }
            
            $this->logProductHistory($product, 'stock_updated', $message);

            DB::commit();
            return $product;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Get popular products
     */
    public function getPopularProducts(int $limit = 8)
    {
        return Product::select('products.*', DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total_sold'))
            ->leftJoin('transaction_items', 'products.id', '=', 'transaction_items.product_id')
            ->leftJoin('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where(function ($query) {
                $query->whereNull('transactions.status')
                      ->orWhereIn('transactions.status', ['paid', 'processing', 'shipped', 'delivered']);
            })
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get low stock products
     */
    public function getLowStockProducts(int $threshold = 10)
    {
        return Product::where('stock', '<=', $threshold)
            ->orderBy('stock', 'asc')
            ->get();
    }

    /**
     * Generate unique slug
     */
    protected function generateSlug(string $name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Log product history
     */
    protected function logProductHistory(Product $product, string $action, string $description)
    {
        ProductHistory::create([
            'product_id' => $product->id,
            'action' => $action,
            'description' => $description,
            'user_id' => Auth::id(),
            'created_at' => now()
        ]);
    }

    /**
     * Get product by slug
     */
    public function getBySlug(string $slug)
    {
        return Product::with(['plantType'])->where('slug', $slug)->firstOrFail();
    }

    /**
     * Validate product stock and purchase requirements
     */
    public function validateProductPurchase(Product $product, $quantity)
    {
        $availableStock = $product->stock - $product->minimum_stock;
        $minimalPembelian = $product->minimum_purchase ?? 1;
        
        // Check stock availability
        if ($availableStock <= 0) {
            throw new \Exception('Product "' . $product->product_name . '" is out of stock.');
        }
        
        // Validate minimum purchase
        if ($quantity < $minimalPembelian) {
            throw new \Exception('Product "' . $product->product_name . '" minimum purchase: ' . number_format($minimalPembelian, 0, ',', '') . ' ' . $product->unit);
        }
        
        // Check if quantity exceeds available stock
        if ($quantity > $availableStock) {
            throw new \Exception('Product "' . $product->product_name . '" insufficient stock. Maximum: ' . $availableStock . ' ' . $product->unit);
        }
        
        return true;
    }

    /**
     * Normalize quantity based on unit type
     */
    public function normalizeQuantity(Product $product, $inputQuantity)
    {
        $minimalPembelian = $product->minimum_purchase ?? 1;
        $satuan = strtolower($product->unit ?? '');
        
        if (in_array($satuan, ['mata', 'tanaman', 'rizome'])) {
            return max($minimalPembelian, (int) $inputQuantity);
        } else {
            return max($minimalPembelian, (float) $inputQuantity);
        }
    }

    /**
     * Get available stock for product (excluding minimum stock)
     */
    public function getAvailableStock(Product $product)
    {
        return max(0, $product->stock - $product->minimum_stock);
    }

    /**
     * Get related products
     */
    public function getRelatedProducts(Product $product, int $limit = 4)
    {
        return Product::where('plant_type_id', $product->plant_type_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
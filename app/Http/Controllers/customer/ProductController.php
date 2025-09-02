<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PlantTypes;
use App\Models\ProductHistory;

class ProductController extends Controller
{
    public function home(Request $request)
    {
        $q = $request->input('q');
        if ($q) {
            $keywords = preg_split('/\s+/', trim($q));
            $products = Product::where(function($query) use ($keywords) {
                foreach ($keywords as $word) {
                    $query->where(function($sub) use ($word) {
                        $sub->where('product_name', 'like', "%$word%")
                             ->orWhere('description', 'like', "%$word%")
                             ;
                    });
                }
            })->get();
            session()->forget('displayed_products');
        } else {
            // Reset session untuk memulai dari awal
            session()->forget('displayed_products');
            $products = Product::inRandomOrder()->take(10)->get();
            session(['displayed_products' => $products->pluck('product_id')->toArray()]);
        }
        $latestProducts = Product::orderBy('product_id', 'desc')->take(5)->pluck('product_id')->toArray();
        return view('customer.home', compact('products', 'q', 'latestProducts'));
    }

    public function loadMore(Request $request)
    {
        try {
            $offset = $request->input('offset', 0);
            $limit = 10;
            $displayedProducts = session('displayed_products', []);
            
            
            
            $products = Product::whereNotIn('product_id', $displayedProducts)
                              ->inRandomOrder()
                              ->take($limit)
                              ->get();
            
        
            $newDisplayedProducts = array_merge($displayedProducts, $products->pluck('product_id')->toArray());
            session(['displayed_products' => $newDisplayedProducts]);
            
            $totalProducts = Product::count();
            $html = '';
            
            if ($products->count() > 0) {
                foreach ($products as $product) {
                    try {
                        $html .= view('customer.partials.product-card', compact('product'))->render();
                    } catch (\Exception $e) {
                        // Skip produk yang error, lanjut ke produk berikutnya
                        continue;
                    }
                }
            }
            
            $response = [
                'html' => $html,
                'hasMore' => count($newDisplayedProducts) < $totalProducts && $products->count() > 0,
                'totalLoaded' => count($newDisplayedProducts),
                'totalProducts' => $totalProducts
            ];
            
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            
            return response()->json([
                'error' => 'Terjadi kesalahan saat memuat produk.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function resetSession()
    {
        session()->forget('displayed_products');
        return response()->json(['success' => true]);
    }

    public function detail($product_id)
    {
        $product = Product::findOrFail($product_id);
        $latestProducts = Product::orderBy('product_id', 'desc')->take(5)->pluck('product_id')->toArray();
        return view('customer.detail_produk_costumer', compact('product', 'latestProducts'));
    }

    public function historyDetail($history_id)
    {
        $productHistory = ProductHistory::findOrFail($history_id);
        $currentProduct = Product::find($productHistory->product_id);
        $latestProducts = Product::orderBy('product_id', 'desc')->take(5)->pluck('product_id')->toArray();
        
        // Cek apakah produk masih tersedia
        $isProductAvailable = $currentProduct && ($currentProduct->stock - $currentProduct->minimum_stock) > 0;
        
        return view('customer.detail_produk_history', compact('productHistory', 'currentProduct', 'latestProducts', 'isProductAvailable'));
    }

    public function baru()
    {
        $kategori = request('kategori', []);
        $query = Product::orderBy('product_id', 'desc');
        if (!empty($kategori)) {
            $query->whereHas('plantType', function($q) use ($kategori) {
                $map = [
                    'pemanis' => 'Tanaman Pemanis',
                    'serat' => 'Tanaman Serat',
                    'tembakau' => 'Tanaman Tembakau',
                    'minyak' => 'Tanaman Minyak Industri',
                ];
                $comodities = array_map(fn($k) => $map[$k] ?? $k, $kategori);
                $q->whereIn('comodity', $comodities);
            });
        }
        $products = $query->take(5)->get();
        $latestProducts = Product::orderBy('product_id', 'desc')->take(5)->pluck('product_id')->toArray();
        return view('customer.produk_baru', compact('products', 'latestProducts'));
    }

    public function kategori($kategori)
    {
        $map = [
            'pemanis' => ['Tanaman Pemanis', 'Tanaman Pemanis'],
            'serat' => ['Tanaman Serat', 'Tanaman Serat'],
            'tembakau' => ['Tanaman Tembakau', 'Tanaman Tembakau'],
            'minyak' => ['Tanaman Minyak Industri', 'Tanaman Minyak Industri'],
        ];
        if (!isset($map[$kategori])) abort(404);
        [$jenis_kategori, $judul] = $map[$kategori];
        $plantTypes = PlantTypes::where('comodity', $jenis_kategori)->get();
        
        // Get filter parameters
        $plantTypeIds = request('plant_types', []);
        $minPrice = request('min_price');
        $maxPrice = request('max_price');
        $stockFilter = request('stock_filter', 'all');
        $sort = request('sort', 'name-asc');
        
        // Build query
        $query = Product::whereHas('plantType', function($q) use ($jenis_kategori, $plantTypeIds) {
            $q->where('comodity', $jenis_kategori);
            if (!empty($plantTypeIds)) {
                $q->whereIn('plant_type_id', $plantTypeIds);
            }
        });
        
        // Apply price filters
        if ($minPrice !== null && $minPrice !== '') {
            $query->where('price_per_unit', '>=', $minPrice);
        }
        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('price_per_unit', '<=', $maxPrice);
        }
        
        // Apply stock filters
        switch ($stockFilter) {
            case 'available':
                $query->whereRaw('(stock - minimum_stock) > 0');
                break;
            case 'low':
                $query->whereRaw('(stock - minimum_stock) <= 10')->whereRaw('(stock - minimum_stock) > 0');
                break;
            case 'all':
            default:
                // No filter applied
                break;
        }
        
        // Apply sorting
        switch ($sort) {
            case 'name-asc':
                $query->orderBy('product_name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('product_name', 'desc');
                break;
            case 'price-low':
                $query->orderBy('price_per_unit', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price_per_unit', 'desc');
                break;
            case 'stock-high':
                $query->orderByRaw('(stock - minimum_stock) DESC');
                break;
            case 'stock-low':
                $query->orderByRaw('(stock - minimum_stock) ASC');
                break;
            default:
                $query->orderBy('product_name', 'asc');
                break;
        }
        
        $products = $query->get();
        $latestProducts = Product::orderBy('product_id', 'desc')->take(5)->pluck('product_id')->toArray();
        
        return view('customer.kategori', compact('products', 'latestProducts', 'judul', 'plantTypes'));
    }
} 
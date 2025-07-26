<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PlantTypes;

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
            session()->forget('displayed_products');
            $products = Product::inRandomOrder()->take(10)->get();
            session(['displayed_products' => $products->pluck('product_id')->toArray()]);
        }
        $latestProducts = Product::orderBy('product_id', 'desc')->take(5)->pluck('product_id')->toArray();
        return view('customer.home', compact('products', 'q', 'latestProducts'));
    }

    public function loadMore(Request $request)
    {
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
        foreach ($products as $produk) {
            $html .= view('customer.partials.product-card', compact('produk'))->render();
        }
        return response()->json([
            'html' => $html,
            'hasMore' => count($newDisplayedProducts) < $totalProducts,
            'totalLoaded' => count($newDisplayedProducts),
            'totalProducts' => $totalProducts
        ]);
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

    public function baru()
    {
        $products = Product::orderBy('product_id', 'desc')->take(5)->get();
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
        $plantTypeIds = request('plant_types', []);
        $products = Product::whereHas('plantType', function($q) use ($jenis_kategori, $plantTypeIds) {
            $q->where('comodity', $jenis_kategori);
            if (!empty($plantTypeIds)) {
                $q->whereIn('plant_type_id', $plantTypeIds);
            }
        })->get();
        $latestProducts = Product::orderBy('product_id', 'desc')->take(5)->pluck('product_id')->toArray();
        return view('customer.kategori', compact('products', 'latestProducts', 'judul', 'plantTypes'));
    }
} 
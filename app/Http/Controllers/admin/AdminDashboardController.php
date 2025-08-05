<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Complaint;
use App\Models\RegProvinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    
        public function productDistribution(Request $request)
    {
        // Ambil data untuk filter
        $allProvinces = DB::table('reg_provinces')
            ->select('id as province_id', 'name as province_name')
            ->orderBy('name')
            ->get()
            ->keyBy('province_id');

        $allPlantTypes = DB::table('plant_types')
            ->select('plant_type_id', 'plant_type_name')
            ->orderBy('plant_type_name')
            ->get();

        // Mengambil semua produk untuk filter
        $allProducts = DB::table('products')
            ->select('product_id', 'product_name', 'plant_type_id')
            ->orderBy('product_name')
            ->get();

        // Filter parameters
        $selectedProvince = $request->get('province_id');
        $selectedPlantType = $request->get('plant_type_id');
        $selectedProduct = $request->get('product_id');

        // Base query untuk province data
        $provinceQuery = DB::table('transactions as t')
            ->join('transaction_items as ti', 't.transaction_id', '=', 'ti.transaction_id')
            ->join('products as p', 'ti.product_id', '=', 'p.product_id')
            ->join('plant_types as pt', 'p.plant_type_id', '=', 'pt.plant_type_id')
            ->join('reg_provinces as rp', 't.province_id', '=', 'rp.id')
            ->whereNotNull('t.province_id')
            ->where('t.order_status', '!=', 'cancelled');

        // Apply filters
        if ($selectedProvince) {
            $provinceQuery->where('t.province_id', $selectedProvince);
        }
        if ($selectedPlantType) {
            $provinceQuery->where('p.plant_type_id', $selectedPlantType);
        }
        if ($selectedProduct) {
            $provinceQuery->where('p.product_id', $selectedProduct);
        }

        // Mengambil data produk per provinsi
        $provinceData = $provinceQuery
            ->select(
                'rp.id as province_id',
                'rp.name as province_name',
                DB::raw('COUNT(DISTINCT ti.product_id) as total_products'),
                DB::raw('SUM(ti.quantity) as total_quantity'),
                DB::raw('SUM(ti.subtotal) as total_value')
            )
            ->groupBy('rp.id', 'rp.name')
            ->get();

        // Mengambil detail produk per provinsi untuk hover
        $provinceProductsQuery = DB::table('transactions as t')
            ->join('transaction_items as ti', 't.transaction_id', '=', 'ti.transaction_id')
            ->join('products as p', 'ti.product_id', '=', 'p.product_id')
            ->join('plant_types as pt', 'p.plant_type_id', '=', 'pt.plant_type_id')
            ->join('reg_provinces as rp', 't.province_id', '=', 'rp.id')
            ->whereNotNull('t.province_id')
            ->where('t.order_status', '!=', 'cancelled');

        // Apply filters untuk province products
        if ($selectedProvince) {
            $provinceProductsQuery->where('t.province_id', $selectedProvince);
        }
        if ($selectedPlantType) {
            $provinceProductsQuery->where('p.plant_type_id', $selectedPlantType);
        }
        if ($selectedProduct) {
            $provinceProductsQuery->where('p.product_id', $selectedProduct);
        }

        $provinceProducts = $provinceProductsQuery
            ->select(
                'rp.id as province_id',
                'rp.name as province_name',
                'p.product_id',
                'p.product_name as product_name',
                'p.unit',
                'p.plant_type_id',
                DB::raw('SUM(ti.quantity) as total_quantity'),
                DB::raw('SUM(ti.subtotal) as total_value')
            )
            ->groupBy('rp.id', 'rp.name', 'p.product_id', 'p.product_name', 'p.unit', 'p.plant_type_id')
            ->get()
            ->groupBy('province_id');

        // Mengambil data produk per kabupaten/kota
        $regencyDataQuery = DB::table('transactions as t')
            ->join('transaction_items as ti', 't.transaction_id', '=', 'ti.transaction_id')
            ->join('products as p', 'ti.product_id', '=', 'p.product_id')
            ->join('plant_types as pt', 'p.plant_type_id', '=', 'pt.plant_type_id')
            ->join('reg_regencies as rr', 't.regency_id', '=', 'rr.id')
            ->whereNotNull('t.regency_id')
            ->where('t.order_status', '!=', 'cancelled');

        // Apply filters untuk regency data
        if ($selectedProvince) {
            $regencyDataQuery->where('rr.province_id', $selectedProvince);
        }
        if ($selectedPlantType) {
            $regencyDataQuery->where('p.plant_type_id', $selectedPlantType);
        }
        if ($selectedProduct) {
            $regencyDataQuery->where('p.product_id', $selectedProduct);
        }
        
        // Debug: Log query untuk memastikan filter bekerja dengan benar
        \Log::info('Regency Data Query:', [
            'selectedProvince' => $selectedProvince,
            'selectedPlantType' => $selectedPlantType,
            'query' => $regencyDataQuery->toSql(),
            'bindings' => $regencyDataQuery->getBindings()
        ]);

        $regencyData = $regencyDataQuery
            ->select(
                'rr.id as regency_id',
                'rr.name as regency_name',
                'rr.province_id',
                DB::raw('COUNT(DISTINCT ti.product_id) as total_products'),
                DB::raw('SUM(ti.quantity) as total_quantity'),
                DB::raw('SUM(ti.subtotal) as total_value')
            )
            ->groupBy('rr.id', 'rr.name', 'rr.province_id')
            ->get();

        // Mengambil detail produk per kabupaten/kota untuk hover
        $regencyProductsQuery = DB::table('transactions as t')
            ->join('transaction_items as ti', 't.transaction_id', '=', 'ti.transaction_id')
            ->join('products as p', 'ti.product_id', '=', 'p.product_id')
            ->join('plant_types as pt', 'p.plant_type_id', '=', 'pt.plant_type_id')
            ->join('reg_regencies as rr', 't.regency_id', '=', 'rr.id')
            ->whereNotNull('t.regency_id')
            ->where('t.order_status', '!=', 'cancelled');

        // Apply filters untuk regency products
        if ($selectedProvince) {
            $regencyProductsQuery->where('rr.province_id', $selectedProvince);
        }
        if ($selectedPlantType) {
            $regencyProductsQuery->where('p.plant_type_id', $selectedPlantType);
        }
        if ($selectedProduct) {
            $regencyProductsQuery->where('p.product_id', $selectedProduct);
        }

        $regencyProducts = $regencyProductsQuery
            ->select(
                'rr.id as regency_id',
                'rr.name as regency_name',
                'rr.province_id',
                'p.product_id',
                'p.product_name as product_name',
                'p.unit',
                'p.plant_type_id',
                DB::raw('SUM(ti.quantity) as total_quantity'),
                DB::raw('SUM(ti.subtotal) as total_value')
            )
            ->groupBy('rr.id', 'rr.name', 'rr.province_id', 'p.product_id', 'p.product_name', 'p.unit', 'p.plant_type_id')
            ->get()
            ->groupBy('regency_id');



        // Mengambil semua data kabupaten/kota untuk fallback
        $allRegencies = DB::table('reg_regencies')
            ->select('id as regency_id', 'name as regency_name', 'province_id')
            ->get();


            
        // Debug: Log data yang dikirim ke view
        \Log::info('Data sent to view:', [
            'provinceData_count' => $provinceData->count(),
            'regencyData_count' => $regencyData->count(),
            'regencyProducts_count' => count($regencyProducts),
            'allRegencies_count' => $allRegencies->count()
        ]);
        
        return view('admin.product_distribution', compact(
            'provinceData', 
            'provinceProducts', 
            'regencyData', 
            'regencyProducts', 
            'allProvinces', 
            'allRegencies',
            'allPlantTypes',
            'allProducts',
            'selectedProvince',
            'selectedPlantType',
            'selectedProduct'
        ));
    }
    
    public function transactions(Request $request)
    {
        $query = Transaction::with(['user', 'transactionItems.product', 'payments']);
        
        // Filter by order status
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        
        // Filter by payment status
        if ($request->filled('payment_status')) {
            if ($request->payment_status == 'no_payment') {
                $query->whereDoesntHave('payments');
            } else {
                $query->whereHas('payments', function($q) use ($request) {
                    $q->where('payment_status', $request->payment_status);
                });
            }
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('order_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }
        
        $transactions = $query->orderBy('order_date', 'desc')->get();
        return view('admin.transactions', compact('transactions'));
    }
    
    public function transactionDetail($id)
    {
        $transaction = Transaction::with(['user', 'transactionItems.product', 'payments', 'shippingAddress', 'province', 'regency'])
            ->where('transaction_id', $id)
            ->firstOrFail();
        return view('admin.transaction_detail', compact('transaction'));
    }
    
    public function updateTransactionStatus(Request $request, $id)
    {
        $transaction = Transaction::where('transaction_id', $id)->firstOrFail();
        $transaction->order_status = $request->status;
        $transaction->save();
        
        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui');
    }
    
    public function articles()
    {
        // Untuk sementara, kita akan menggunakan view yang sama dengan dashboard
        // karena belum ada model Article
        return view('admin.articles');
    }
} 
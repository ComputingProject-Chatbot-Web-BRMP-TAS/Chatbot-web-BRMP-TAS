<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PlantTypes;
use App\Models\ProductHistory;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        // Use ProductService for filtering
        $filters = [
            'search' => $request->search,
            'plant_type_id' => $request->plant_type_id,
            'stock_status' => $request->stock_status,
            'has_certificate' => $request->has_certificate,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
            'per_page' => 15
        ];

        $products = $this->productService->getProducts($filters);
        $plantTypes = PlantTypes::all();

        return view('admin.products.index', compact('products', 'plantTypes'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $plantTypes = PlantTypes::all();
        return view('admin.products.create', compact('plantTypes'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'plant_type_id' => 'required|exists:plant_types,plant_type_id',
                'product_name' => 'required|string|max:255',
                'description' => 'required|string',
                'price_per_unit' => 'required|numeric|min:0',
                'unit' => 'required|string|max:50',
                'stock' => 'required|integer|min:0',
                'minimum_stock' => 'required|integer|min:0',
                'minimum_purchase' => 'required|integer|min:1',
                'image1' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'image_certificate' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'certificate_number' => 'nullable|string|max:255',
                'certificate_class' => 'nullable|string|max:255',
                'valid_from' => 'nullable|date',
                'valid_until' => 'nullable|date|after_or_equal:valid_from',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $request->all();
            
            // Handle image uploads
            $image1 = $request->hasFile('image1') ? $request->file('image1') : null;
            $image2 = $request->hasFile('image2') ? $request->file('image2') : null;
            $imageCertificate = $request->hasFile('image_certificate') ? $request->file('image_certificate') : null;

            // Create product using service
            $product = $this->productService->createProduct($data, $image1, $image2, $imageCertificate);

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::with(['plantType', 'histories'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $plantTypes = PlantTypes::all();
        return view('admin.products.edit', compact('product', 'plantTypes'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Validation rules
            $validator = Validator::make($request->all(), [
                'plant_type_id' => 'required|exists:plant_types,plant_type_id',
                'product_name' => 'required|string|max:255',
                'description' => 'required|string',
                'price_per_unit' => 'required|numeric|min:0',
                'unit' => 'required|string|max:50',
                'stock' => 'required|integer|min:0',
                'minimum_stock' => 'required|integer|min:0',
                'minimum_purchase' => 'required|integer|min:1',
                'image1' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'image_certificate' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'certificate_number' => 'nullable|string|max:255',
                'certificate_class' => 'nullable|string|max:255',
                'valid_from' => 'nullable|date',
                'valid_until' => 'nullable|date|after_or_equal:valid_from',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = $request->all();
            
            // Handle image uploads
            $image1 = $request->hasFile('image1') ? $request->file('image1') : null;
            $image2 = $request->hasFile('image2') ? $request->file('image2') : null;
            $imageCertificate = $request->hasFile('image_certificate') ? $request->file('image_certificate') : null;

            // Update product using service
            $updatedProduct = $this->productService->updateProduct($product, $data, $image1, $image2, $imageCertificate);

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Delete product using service
            $this->productService->deleteProduct($product);

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Update product stock.
     */
    public function updateStock(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:1',
                'type' => 'required|in:add,subtract',
                'reason' => 'nullable|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            // Update stock using service
            $this->productService->updateStock(
                $product, 
                $request->quantity, 
                $request->type, 
                $request->reason
            );

            return response()->json([
                'success' => true, 
                'message' => 'Stock berhasil diperbarui',
                'new_stock' => $product->stock
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get low stock products.
     */
    public function lowStock()
    {
        $lowStockProducts = $this->productService->getLowStockProducts(10);
        return view('admin.products.low-stock', compact('lowStockProducts'));
    }

    /**
     * Export products to Excel.
     */
    public function export(Request $request)
    {
        try {
            $filters = [
                'search' => $request->search,
                'plant_type_id' => $request->plant_type_id,
                'stock_status' => $request->stock_status,
                'per_page' => 1000 // Export all matching records
            ];

            $products = $this->productService->getProducts($filters);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Headers
            $headers = [
                'ID', 'Nama Produk', 'Jenis Tanaman', 'Deskripsi', 
                'Harga per Unit', 'Satuan', 'Stok', 'Stok Minimum', 
                'Pembelian Minimum', 'Nomor Sertifikat', 'Kelas Sertifikat',
                'Tanggal Dibuat'
            ];

            $sheet->fromArray($headers, null, 'A1');

            // Data
            $row = 2;
            foreach ($products as $product) {
                $data = [
                    $product->product_id,
                    $product->product_name,
                    $product->plantType->plant_type_name ?? '',
                    $product->description,
                    $product->price_per_unit,
                    $product->unit,
                    $product->stock,
                    $product->minimum_stock,
                    $product->minimum_purchase,
                    $product->certificate_number ?? '',
                    $product->certificate_class ?? '',
                    $product->created_at->format('Y-m-d H:i:s')
                ];
                $sheet->fromArray($data, null, 'A' . $row);
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'products_export_' . now()->format('Y_m_d_H_i_s') . '.xlsx';
            $tempFile = tempnam(sys_get_temp_dir(), $filename);
            $writer->save($tempFile);

            return response()->download($tempFile, $filename)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal export data: ' . $e->getMessage());
        }
    }

    /**
     * Show product history.
     */
    public function history($id)
    {
        $product = Product::with(['plantType', 'histories' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        
        return view('admin.products.history', compact('product'));
    }
}
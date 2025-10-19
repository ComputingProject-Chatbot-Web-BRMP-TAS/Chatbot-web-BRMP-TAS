<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Address;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\TransactionService;
use App\Services\AddressService;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $transactionService;
    protected $addressService;

    public function __construct(
        CartService $cartService, 
        TransactionService $transactionService,
        AddressService $addressService
    ) {
        $this->cartService = $cartService;
        $this->transactionService = $transactionService;
        $this->addressService = $addressService;
    }
    public function show(Request $request)
    {
        $user = Auth::user();
        $selectedId = session('checkout_address_id');
        
        if ($selectedId) {
            $address = Address::where('user_id', $user->user_id)->where('address_id', $selectedId)->first();
        } else {
            $address = $this->addressService->getPrimaryAddress($user);
        }
        
        $addresses = $this->addressService->getUserAddresses($user);
        
        // Ambil data cart dari session jika ada
        $cart = session('checkout_cart', []);
        $total = session('checkout_total', 0);
        
        return view('customer.checkout', compact('address', 'addresses', 'cart', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $checkedItems = json_decode($request->input('checked_items', '[]'), true);

        if (empty($checkedItems)) {
            return redirect()->route('cart')->with('error', 'Pilih minimal satu barang untuk checkout');
        }

        // Cek apakah user sudah punya alamat
        $user = Auth::user();
        $addresses = $this->addressService->getUserAddresses($user);
        
        if ($addresses->isEmpty()) {
            return back()->with('error', 'Silakan tambahkan alamat pengiriman terlebih dahulu sebelum checkout.');
        }

        // Ambil data cart items yang dipilih
        $cartItems = CartItem::whereIn('cart_item_id', $checkedItems)
            ->with('product')
            ->get();

        // Validasi stok dan minimal pembelian untuk setiap item
        foreach ($cartItems as $item) {
            $availableStock = $item->product->stock - $item->product->minimum_stock;
            $minimalPembelian = $item->product->minimum_purchase ?? 1;
            
            if ($availableStock <= 0) {
                return redirect()->route('cart')->with('error', 'Produk "' . $item->product->product_name . '" stoknya telah habis. Silakan hapus dari keranjang.');
            }
            
            if ($item->quantity < $minimalPembelian) {
                return redirect()->route('cart')->with('error', 'Produk "' . $item->product->product_name . '" minimal pembelian: ' . number_format($minimalPembelian, 0, ',', '') . ' ' . $item->product->unit);
            }
            
            if ($item->quantity > $availableStock) {
                return redirect()->route('cart')->with('error', 'Produk "' . $item->product->product_name . '" stoknya tidak mencukupi. Maksimal: ' . $availableStock . ' ' . $item->product->unit);
            }
        }

        // Format data untuk session
        $cart = [];
        $total = 0;

        foreach ($cartItems as $item) {
            $cart[] = [
                'cart_item_id' => $item->cart_item_id,
                'product_id' => $item->product->product_id,
                'name' => $item->product->product_name,
                'price' => $item->price_per_unit,
                'quantity' => $item->quantity,
                'subtotal' => $item->price_per_unit * $item->quantity,
                'image' => $item->product->image1,
                'unit' => $item->product->unit
            ];
            $total += $item->price_per_unit * $item->quantity;
        }

        // Simpan ke session
        session(['checkout_cart' => $cart]);
        session(['checkout_total' => $total]);

        return redirect()->route('checkout.show');
    }

    // Set alamat pengiriman untuk checkout (bukan set primary di database, hanya untuk sesi checkout)
    public function setAddress(Request $request, $addressId)
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->user_id)->where('address_id', $addressId)->firstOrFail();
        // Simpan id alamat terpilih ke session
        session(['checkout_address_id' => $address->address_id]);
        // Redirect ke halaman checkout, alamat utama akan diganti dengan alamat terpilih
        return redirect()->route('checkout.show');
    }

    public function next(Request $request)
    {
        try {
            $user = Auth::user();
            $cart = session('checkout_cart', []);
            $total = session('checkout_total', 0);
            $shipping_method = $request->input('shipping_method', 'reguler');

            // Validation
            if (empty($cart) || empty($total)) {
                return redirect()->route('cart')->with('error', 'Silakan checkout ulang dari keranjang.');
            }

            if (empty($shipping_method)) {
                return redirect()->back()->with('error', 'Silakan pilih metode pengiriman.');
            }

            // Validate form data
            $purchase_purpose = $request->input('purchase_purpose');
            $province = $request->input('province');
            $city = $request->input('city');

            if (empty($purchase_purpose) || empty($province) || empty($city)) {
                return redirect()->back()->with('error', 'Tolong lengkapi data terlebih dahulu.');
            }

            // Get shipping address
            $selectedId = session('checkout_address_id');
            if ($selectedId) {
                $address = Address::where('user_id', $user->user_id)->where('address_id', $selectedId)->first();
            } else {
                $address = $this->addressService->getPrimaryAddress($user);
            }

            if (!$address) {
                return redirect()->route('addresses')->with('error', 'Silakan pilih alamat pengiriman terlebih dahulu.');
            }

            // Prepare additional data for transaction
            $additionalData = [
                'shipping_method' => $shipping_method,
                'purchase_purpose' => $purchase_purpose,
                'province' => $province,
                'city' => $city,
                'insurance' => 0, // For now set to 0
                'cart_item_ids' => collect($cart)->pluck('cart_item_id')->toArray()
            ];

            // Create transaction using service
            $transaction = $this->transactionService->createFromCartItems($user, $address, $cart, $additionalData);

            // Clear checkout session data
            session()->forget(['checkout_cart', 'checkout_total', 'checkout_address_id']);
            
            // Set session data for payment page
            session(['checkout_shipping_method' => $shipping_method]);
            session(['current_transaction_id' => $transaction->transaction_id]);

            return redirect()->route('transaksi.detail', ['id' => $transaction->transaction_id])
                ->with('success', 'Transaksi berhasil dibuat! Silakan menunggu kode billing.');

        } catch (\Exception $e) {
            return redirect()->route('cart')->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $selectedId = session('checkout_address_id');
        if ($selectedId) {
            $address = Address::where('user_id', $user->id)->where('id', $selectedId)->first();
        } else {
            $address = Address::where('user_id', $user->id)->where('is_primary', true)->first();
        }
        $addresses = Address::where('user_id', $user->id)->get();
        // Ambil data cart dari session jika ada
        $cart = session('checkout_cart', []);
        $total = session('checkout_total', 0);
        return view('checkout', compact('address', 'addresses', 'cart', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $checkedItems = json_decode($request->input('checked_items', '[]'), true);
        
        if (empty($checkedItems)) {
            return redirect()->route('cart')->with('error', 'Pilih minimal satu barang untuk checkout');
        }
        
        // Cek apakah user sudah punya alamat
        $user = Auth::user();
        $hasAddress = \App\Models\Address::where('user_id', $user->id)->exists();
        if (!$hasAddress) {
            return redirect()->route('addresses')->with('error', 'Silakan tambahkan alamat pengiriman terlebih dahulu sebelum checkout.');
        }
        
        // Ambil data cart items yang dipilih
        $cartItems = CartItem::whereIn('cart_item_id', $checkedItems)
            ->with('product')
            ->get();
        
        // Format data untuk session
        $cart = [];
        $total = 0;
        
        foreach ($cartItems as $item) {
            $cart[] = [
                'cart_item_id' => $item->cart_item_id,
                'product_id' => $item->product->produk_id,
                'name' => $item->product->nama,
                'price' => $item->harga_satuan,
                'qty' => $item->kuantitas,
                'subtotal' => $item->harga_satuan * $item->kuantitas,
                'image' => $item->product->gambar
            ];
            $total += $item->harga_satuan * $item->kuantitas;
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
        $address = Address::where('user_id', $user->id)->where('id', $addressId)->firstOrFail();
        // Simpan id alamat terpilih ke session
        session(['checkout_address_id' => $address->id]);
        // Redirect ke halaman checkout, alamat utama akan diganti dengan alamat terpilih
        return redirect()->route('checkout.show');
    }

    public function next(Request $request)
    {
        $user = Auth::user();
        $cart = session('checkout_cart', []);
        $total = session('checkout_total', 0);
        $shipping_method = $request->input('shipping_method', 'Standard');
        
        // Validasi data checkout
        if (empty($cart) || empty($total)) {
            return redirect()->route('cart')->with('error', 'Silakan checkout ulang dari keranjang.');
        }
        
        // Cek apakah user sudah punya alamat
        $selectedId = session('checkout_address_id');
        if ($selectedId) {
            $address = Address::where('user_id', $user->id)->where('id', $selectedId)->first();
        } else {
            $address = Address::where('user_id', $user->id)->where('is_primary', true)->first();
        }
        
        if (!$address) {
            return redirect()->route('addresses')->with('error', 'Silakan pilih alamat pengiriman terlebih dahulu.');
        }
        
        // Hitung ongkir dan asuransi (untuk sementara 0)
        $ongkir = 0;
        $asuransi = 0;
        $order_date = Carbon::now('Asia/Jakarta');
        
        // Tentukan estimasi tanggal pengiriman berdasarkan metode pengiriman
        $estimated_delivery_date = null;
        switch (strtolower($shipping_method)) {
            case 'standard':
                $estimated_delivery_date = $order_date->copy()->addDays(4);
                break;
            case 'kargo':
                $estimated_delivery_date = $order_date->copy()->addDays(7);
                break;
            case 'reguler':
                $estimated_delivery_date = $order_date->copy()->addDays(5);
                break;
            case 'instant':
                $estimated_delivery_date = $order_date;
                break;
            case 'sameday':
                $estimated_delivery_date = $order_date;
                break;
            case 'ekonomi':
                $estimated_delivery_date = $order_date->copy()->addDays(8);
                break;
            default:
                $estimated_delivery_date = $order_date->copy()->addDays(4);
        }
        
        // Buat transaksi baru dengan status 'menunggu_pembayaran'
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'shipping_address_id' => $address->id,
            'recipient_name' => $address->recipient_name,
            'shipping_address' => $address->address,
            'recipient_phone' => $address->recipient_phone,
            'shipping_note' => $address->note,
            'order_date' => $order_date,
            'total_harga' => $total + $ongkir + $asuransi,
            'status_order' => 'menunggu_pembayaran',
            'delivery_method' => $shipping_method,
            'estimated_delivery_date' => $estimated_delivery_date,
        ]);
        
        // Buat detail item transaksi
        foreach ($cart as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->transaksi_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['qty'],
                'unit_price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }
        
        // Hapus item dari cart setelah transaksi dibuat
        $cartItemIds = collect($cart)->pluck('cart_item_id')->toArray();
        CartItem::whereIn('cart_item_id', $cartItemIds)->delete();
        
        // Simpan data ke session untuk halaman payment
        session(['checkout_shipping_method' => $shipping_method]);
        session(['current_transaction_id' => $transaction->transaksi_id]);
        
        // Redirect ke halaman payment
        return redirect()->route('payment.show')->with('success', 'Transaksi berhasil dibuat! Silakan lakukan pembayaran.');
    }
}

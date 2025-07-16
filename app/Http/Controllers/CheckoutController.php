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
        // Simpan shipping method ke session jika ada
        $shipping_method = $request->input('shipping_method', 'Standard');
        session(['checkout_shipping_method' => $shipping_method]);
        // Tidak membuat transaksi di sini, hanya redirect ke payment
        return redirect()->route('payment.show');
    }
}

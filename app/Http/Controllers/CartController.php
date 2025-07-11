<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $produkId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($produkId);
        $qty = max(1, (int) $request->input('kuantitas', 1));

        // Cari cart aktif user, jika belum ada buat baru
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id
        ]);

        // Cek apakah produk sudah ada di cart_items
        $cartItem = CartItem::where('cart_id', $cart->cart_id)
            ->where('product_id', $product->produk_id)
            ->first();

        if ($cartItem) {
            // Update kuantitas
            $cartItem->kuantitas += $qty;
            $cartItem->save();
        } else {
            // Tambah item baru
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $product->produk_id,
                'kuantitas' => $qty,
                'harga_satuan' => $product->harga,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}

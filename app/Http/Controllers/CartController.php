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
        if (in_array($product->satuan, ['Mata', 'Tanaman', 'Rizome'])) {
            $qty = max($product->minimal_pembelian, (int) $request->input('kuantitas', $product->minimal_pembelian));
        } else {
            $qty = max($product->minimal_pembelian, (float) $request->input('kuantitas', $product->minimal_pembelian));
        }

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
                'harga_satuan' => $product->harga_per_satuan,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}

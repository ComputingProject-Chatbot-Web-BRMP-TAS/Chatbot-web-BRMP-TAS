<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);
        if (in_array($product->unit, ['Mata', 'Tanaman', 'Rizome'])) {
            $qty = max($product->minimum_purchase, (int) $request->input('quantity', $product->minimum_purchase));
        } else {
            $qty = max($product->minimum_purchase, (float) $request->input('quantity', $product->minimum_purchase));
        }

        // Cari cart aktif user, jika belum ada buat baru
        $cart = Cart::firstOrCreate([
            'user_id' => $user->user_id
        ]);

        // Cek apakah produk sudah ada di cart_items
        $cartItem = CartItem::where('cart_id', $cart->cart_id)
            ->where('product_id', $product->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $qty;
            $cartItem->save();
        } else {
            // Tambah item baru
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $product->product_id,
                'quantity' => $qty,
                'price_per_unit' => $product->price_per_unit,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}

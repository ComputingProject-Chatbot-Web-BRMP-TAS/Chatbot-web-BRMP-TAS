<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Address;

class CartController extends Controller
{
    public function show()
    {
        if (!Auth::check()) return redirect()->route('login');
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->user_id)->first();
        $items = $cart ? $cart->cartItems()->with('product')->get() : collect();
        $total = $items->sum(function($item) { return $item->quantity * $item->price_per_unit; });
        $hasAddress = Address::where('user_id', $user->user_id)->exists();
        return view('customer.cart', compact('items', 'total', 'hasAddress'));
    }

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

    public function deleteItem($cart_item)
    {
        $item = CartItem::findOrFail($cart_item);
        $item->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    public function updateQuantity(Request $request, $cart_item)
    {
        $item = CartItem::findOrFail($cart_item);
        $product = $item->product;
        $minimalPembelian = $product->minimum_purchase ?? 1;
        $satuan = strtolower($product->unit ?? '');
        $inputQty = $request->input('quantity', $minimalPembelian);
        if (in_array($satuan, ['mata', 'tanaman', 'rizome'])) {
            $qty = max($minimalPembelian, (int) $inputQty);
        } else {
            $qty = max($minimalPembelian, (float) $inputQty);
        }
        $item->quantity = $qty;
        $item->save();
        return response()->json([
            'success' => true,
            'quantity' => $item->quantity,
            'subtotal' => number_format($item->price_per_unit * $item->quantity, 0, ',', '.')
        ]);
    }

    public function checkout(Request $request)
    {
        $checked = $request->input('checked_items', []);
        $items = CartItem::whereIn('cart_item_id', $checked)->with('product')->get();
        $total = $items->sum(function($item) { return $item->quantity * $item->price_per_unit; });
        return view('customer.cart', [
            'items' => $items,
            'total' => $total,
            'checkout_mode' => true
        ]);
    }
} 
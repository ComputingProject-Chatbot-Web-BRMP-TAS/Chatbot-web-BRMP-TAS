<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\AddressService;

class CartController extends Controller
{
    protected $cartService;
    protected $addressService;

    public function __construct(CartService $cartService, AddressService $addressService)
    {
        $this->cartService = $cartService;
        $this->addressService = $addressService;
    }

    public function show()
    {
        if (!Auth::check()) return redirect()->route('login');
        
        $user = Auth::user();
        $cartData = $this->cartService->getCartForCheckout($user);
        $addresses = $this->addressService->getUserAddresses($user);
        
        return view('customer.cart', [
            'items' => $cartData['items'],
            'total' => $cartData['total'],
            'hasAddress' => !$addresses->isEmpty()
        ]);
    }

    public function addToCart(Request $request, $productId)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $user = Auth::user();
            $product = Product::findOrFail($productId);
            $quantity = $request->input('quantity', 1);

            $newCartItemId = $this->cartService->addItem($user, $product, $quantity);

            return redirect()->route('cart')->with([
                'success' => 'Produk berhasil ditambahkan ke keranjang!',
                'new_cart_item_id' => $newCartItemId
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteItem($cartItemId)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $user = Auth::user();
            $this->cartService->removeItem($user, $cartItemId);
            
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateQuantity(Request $request, $cartItemId)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $user = Auth::user();
            $quantity = $request->input('quantity');

            $result = $this->cartService->updateQuantity($user, $cartItemId, $quantity);

            return response()->json([
                'success' => true,
                'quantity' => $result['quantity'],
                'subtotal' => number_format($result['subtotal'], 0, ',', '.')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
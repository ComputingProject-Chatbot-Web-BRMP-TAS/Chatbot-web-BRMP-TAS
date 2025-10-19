<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartService
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Add item to cart with proper validation and stock checking
     */
    public function addItem(User $user, Product $product, $quantity = 1)
    {
        try {
            DB::beginTransaction();

            // Validate quantity input
            if (empty($quantity) || $quantity == 0) {
                throw new \Exception('Silakan masukkan jumlah yang ingin dibeli');
            }

            // Normalize quantity based on unit type
            $qty = $this->productService->normalizeQuantity($product, $quantity);

            // Validate product purchase requirements
            $this->productService->validateProductPurchase($product, $qty);
            
            // Get available stock for cart logic
            $availableStock = $this->productService->getAvailableStock($product);

            // Get or create cart for user
            $cart = Cart::firstOrCreate([
                'user_id' => $user->user_id // Note: using user_id not id based on your schema
            ]);

            // Check if item already exists in cart
            $cartItem = CartItem::where('cart_id', $cart->cart_id)
                ->where('product_id', $product->product_id)
                ->first();

            if ($cartItem) {
                // Check total quantity after addition doesn't exceed stock
                $totalQuantity = $cartItem->quantity + $qty;
                if ($totalQuantity > $availableStock) {
                    throw new \Exception('Maaf, stok tidak mencukupi untuk menambahkan ke keranjang.');
                }
                
                // Update quantity if item exists
                $cartItem->quantity = $totalQuantity;
                $cartItem->save();
                $newCartItemId = $cartItem->cart_item_id;
            } else {
                // Create new cart item (validation already done above)
                $newItem = CartItem::create([
                    'cart_id' => $cart->cart_id,
                    'product_id' => $product->product_id,
                    'quantity' => $qty,
                    'price_per_unit' => $product->price_per_unit,
                ]);
                $newCartItemId = $newItem->cart_item_id;
            }

            DB::commit();
            
            Log::info('Item added to cart', [
                'user_id' => $user->user_id,
                'product_id' => $product->product_id,
                'quantity' => $qty,
                'cart_item_id' => $newCartItemId
            ]);

            return $newCartItemId;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to add item to cart', [
                'user_id' => $user->user_id ?? null,
                'product_id' => $product->product_id ?? null,
                'quantity' => $quantity,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Update item quantity in cart with validation
     */
    public function updateQuantity(User $user, int $cartItemId, $quantity)
    {
        try {
            DB::beginTransaction();

            $cartItem = CartItem::where('cart_item_id', $cartItemId)
                ->whereHas('cart', function($query) use ($user) {
                    $query->where('user_id', $user->user_id);
                })
                ->with('product')
                ->firstOrFail();

            $product = $cartItem->product;
            
            // Validate quantity input
            if (empty($quantity) || $quantity == 0) {
                throw new \Exception('Silakan masukkan jumlah yang ingin dibeli');
            }
            
            // Normalize quantity based on unit type
            $qty = $this->productService->normalizeQuantity($product, $quantity);
            
            // Validate product purchase requirements
            $this->productService->validateProductPurchase($product, $qty);
            
            $cartItem->quantity = $qty;
            $cartItem->save();

            DB::commit();

            Log::info('Cart item quantity updated', [
                'user_id' => $user->user_id,
                'cart_item_id' => $cartItemId,
                'new_quantity' => $qty
            ]);

            return [
                'quantity' => $cartItem->quantity,
                'subtotal' => $cartItem->price_per_unit * $cartItem->quantity
            ];

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update cart quantity', [
                'user_id' => $user->user_id,
                'cart_item_id' => $cartItemId,
                'quantity' => $quantity,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Remove item from cart
     */
    public function removeItem(User $user, int $cartItemId)
    {
        try {
            $cartItem = CartItem::where('cart_item_id', $cartItemId)
                ->whereHas('cart', function($query) use ($user) {
                    $query->where('user_id', $user->user_id);
                })
                ->firstOrFail();

            $cartItem->delete();

            Log::info('Item removed from cart', [
                'user_id' => $user->user_id,
                'cart_item_id' => $cartItemId
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to remove cart item', [
                'user_id' => $user->user_id,
                'cart_item_id' => $cartItemId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get cart items for user
     */
    public function getCartItems(User $user)
    {
        $cart = Cart::where('user_id', $user->user_id)->first();
        
        if (!$cart) {
            return collect();
        }

        return CartItem::where('cart_id', $cart->cart_id)
            ->with('product')
            ->get();
    }

    /**
     * Calculate cart total
     */
    public function getCartTotal(User $user)
    {
        $cartItems = $this->getCartItems($user);
        
        return $cartItems->sum(function ($item) {
            return $item->quantity * $item->price_per_unit;
        });
    }

    /**
     * Clear cart
     */
    public function clearCart(User $user)
    {
        $cart = Cart::where('user_id', $user->user_id)->first();
        
        if ($cart) {
            CartItem::where('cart_id', $cart->cart_id)->delete();
            
            Log::info('Cart cleared', ['user_id' => $user->user_id]);
            return true;
        }

        return false;
    }

    /**
     * Get cart item count
     */
    public function getCartCount(User $user)
    {
        $cartItems = $this->getCartItems($user);
        return $cartItems->sum('quantity');
    }

    /**
     * Get cart with total for checkout page
     */
    public function getCartForCheckout(User $user)
    {
        $cartItems = $this->getCartItems($user);
        $total = $cartItems->sum(function($item) { 
            return $item->quantity * $item->price_per_unit; 
        });

        return [
            'items' => $cartItems,
            'total' => $total
        ];
    }
}
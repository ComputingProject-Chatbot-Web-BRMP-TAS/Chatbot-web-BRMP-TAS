<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TransactionService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Create transaction from cart items with complete validation
     */
    public function createFromCartItems(User $user, Address $address, array $cartItems, array $additionalData = [])
    {
        try {
            DB::beginTransaction();

            // Validate cart items
            if (empty($cartItems)) {
                throw new \Exception('Cart is empty');
            }

            // Validate all items before processing
            $this->validateCartItemsStock($cartItems);

            // Calculate totals
            $subtotal = collect($cartItems)->sum('subtotal');
            $shippingCost = $this->calculateShippingCost($address, $additionalData['shipping_method'] ?? 'reguler');
            $insurance = $additionalData['insurance'] ?? 0;
            $total = $subtotal + $shippingCost + $insurance;

            // Calculate estimated delivery date
            $estimatedDeliveryDate = $this->calculateEstimatedDelivery($additionalData['shipping_method'] ?? 'reguler');

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $user->user_id,
                'shipping_address_id' => $address->address_id,
                'recipient_name' => $address->recipient_name,
                'shipping_address' => $address->address,
                'recipient_phone' => $address->recipient_phone,
                'shipping_note' => $address->note,
                'purchase_purpose' => $additionalData['purchase_purpose'] ?? null,
                'province_id' => $additionalData['province'] ?? null,
                'regency_id' => $additionalData['city'] ?? null,
                'order_date' => now('Asia/Jakarta'),
                'total_price' => $total,
                'order_status' => 'menunggu_kode_billing',
                'delivery_method' => $additionalData['shipping_method'] ?? 'reguler',
                'estimated_delivery_date' => $estimatedDeliveryDate,
            ]);

            // Create transaction items and update stock
            foreach ($cartItems as $item) {
                // Create transaction item
                TransactionItem::create([
                    'transaction_id' => $transaction->transaction_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
                
                // Update product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    // Final stock validation before reducing
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception('Product "' . $product->product_name . '" insufficient stock during final check.');
                    }
                    $product->stock -= $item['quantity'];
                    $product->save();
                }
            }

            // Remove cart items after successful transaction
            if (isset($additionalData['cart_item_ids']) && !empty($additionalData['cart_item_ids'])) {
                CartItem::whereIn('cart_item_id', $additionalData['cart_item_ids'])->delete();
            }

            DB::commit();
            
            Log::info('Transaction created successfully', [
                'transaction_id' => $transaction->transaction_id,
                'user_id' => $user->user_id,
                'total' => $total
            ]);

            return $transaction;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create transaction', [
                'user_id' => $user->user_id ?? null,
                'error' => $e->getMessage(),
                'cart_items_count' => count($cartItems)
            ]);
            throw $e;
        }
    }

    /**
     * Calculate estimated delivery date based on shipping method
     */
    protected function calculateEstimatedDelivery(string $shippingMethod)
    {
        $orderDate = now('Asia/Jakarta');
        
        switch ($shippingMethod) {
            case 'reguler':
                return $orderDate->copy()->addDays(5);
            case 'kargo':
                return $orderDate->copy()->addDays(7);
            case 'pickup':
                return $orderDate;
            default:
                return $orderDate->copy()->addDays(5);
        }
    }

    /**
     * Update transaction status
     */
    public function updateStatus(Transaction $transaction, string $status)
    {
        $validStatuses = ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            throw new \Exception('Invalid transaction status');
        }

        $transaction->update(['status' => $status]);
        
        return $transaction;
    }

    /**
     * Create payment record
     */
    public function createPayment(Transaction $transaction, array $paymentData)
    {
        return Payment::create([
            'transaction_id' => $transaction->id,
            'payment_method' => $paymentData['method'] ?? 'bank_transfer',
            'amount' => $paymentData['amount'] ?? $transaction->total,
            'status' => $paymentData['status'] ?? 'pending',
            'payment_date' => $paymentData['date'] ?? now(),
            'reference_number' => $paymentData['reference'] ?? null,
            'notes' => $paymentData['notes'] ?? null
        ]);
    }

    /**
     * Calculate shipping cost based on address
     */
    protected function calculateShippingCost(Address $address)
    {
        // Simple shipping calculation - you can implement more complex logic
        $baseCost = 15000; // Base shipping cost
        
        // Add extra cost for remote areas (example logic)
        if (in_array($address->province, ['Papua', 'Papua Barat', 'Maluku'])) {
            $baseCost += 25000;
        }
        
        return $baseCost;
    }

    /**
     * Generate unique transaction code
     */
    protected function generateTransactionCode()
    {
        $prefix = 'TRX';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(6));
        
        return $prefix . $date . $random;
    }

    /**
     * Get transactions for user
     */
    public function getUserTransactions(User $user, string $status = null)
    {
        $query = Transaction::where('user_id', $user->id)
            ->with(['transactionItems.product', 'address', 'payment'])
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    /**
     * Cancel transaction
     */
    public function cancelTransaction(Transaction $transaction, string $reason = null)
    {
        if (!in_array($transaction->status, ['pending', 'paid'])) {
            throw new \Exception('Cannot cancel transaction with status: ' . $transaction->status);
        }

        try {
            DB::beginTransaction();

            // Update transaction status
            $transaction->update([
                'status' => 'cancelled',
                'notes' => $reason
            ]);

            // Update payment status if exists
            if ($transaction->payment) {
                $transaction->payment->update(['status' => 'cancelled']);
            }

            DB::commit();
            return $transaction;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Get transaction summary
     */
    public function getTransactionSummary(Transaction $transaction)
    {
        return [
            'transaction_code' => $transaction->transaction_code,
            'total_items' => $transaction->transactionItems->sum('quantity'),
            'subtotal' => $transaction->subtotal,
            'shipping_cost' => $transaction->shipping_cost,
            'total' => $transaction->total,
            'status' => $transaction->status,
            'payment_status' => $transaction->payment->status ?? 'unpaid',
            'created_at' => $transaction->created_at
        ];
    }

    /**
     * Validate cart items stock and minimum purchase
     */
    private function validateCartItemsStock(array $cartItems)
    {
        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) {
                throw new \Exception('Product not found: ' . $item['name']);
            }
            
            $availableStock = $product->stock - $product->minimum_stock;
            $minimalPembelian = $product->minimum_purchase ?? 1;
            
            if ($availableStock <= 0) {
                throw new \Exception('Product "' . $product->product_name . '" is out of stock.');
            }
            
            if ($item['quantity'] < $minimalPembelian) {
                throw new \Exception('Product "' . $product->product_name . '" minimum purchase: ' . number_format($minimalPembelian, 0, ',', '') . ' ' . $product->unit);
            }
            
            if ($item['quantity'] > $availableStock) {
                throw new \Exception('Product "' . $product->product_name . '" insufficient stock. Maximum: ' . $availableStock . ' ' . $product->unit);
            }
        }
    }
}
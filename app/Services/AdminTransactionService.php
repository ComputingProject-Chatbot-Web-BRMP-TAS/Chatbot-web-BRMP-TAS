<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminTransactionService
{
    /**
     * Update transaction status with proper business logic
     */
    public function updateTransactionStatus(Transaction $transaction, string $newStatus, string $reason = null)
    {
        try {
            DB::beginTransaction();

            $oldStatus = $transaction->order_status;

            // Validate status transition
            $this->validateStatusTransition($oldStatus, $newStatus);

            // Handle status-specific logic
            switch ($newStatus) {
                case 'selesai':
                    if ($oldStatus !== 'selesai') {
                        $transaction->done_date = now();
                    }
                    break;
                    
                case 'dibatalkan':
                    $this->handleCancellation($transaction, $reason);
                    break;
                    
                default:
                    if ($newStatus !== 'selesai') {
                        $transaction->done_date = null;
                    }
                    break;
            }

            $transaction->order_status = $newStatus;
            $transaction->save();

            // Log status change
            Log::info('Transaction status updated', [
                'transaction_id' => $transaction->transaction_id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'reason' => $reason,
                'admin_user' => Auth::id()
            ]);

            DB::commit();
            return $transaction;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update transaction status', [
                'transaction_id' => $transaction->transaction_id,
                'old_status' => $oldStatus ?? null,
                'new_status' => $newStatus,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Approve payment with proper validation
     */
    public function approvePayment(Payment $payment, string $reason = null)
    {
        try {
            DB::beginTransaction();

            $transaction = $payment->transaction;
            
            // Validate that payment is in pending status
            if ($payment->payment_status !== 'pending') {
                throw new \Exception('Pembayaran tidak dapat dikonfirmasi karena status tidak valid.');
            }

            // Update payment status
            $payment->update([
                'payment_status' => 'approved',
                'approval_date' => now(),
                'approval_reason' => $reason
            ]);
            
            // Update transaction status to diproses
            $transaction->update([
                'order_status' => 'diproses',
                'done_date' => $transaction->done_date ?? now()
            ]);

            // Log payment approval
            Log::info('Payment approved', [
                'payment_id' => $payment->payment_id,
                'transaction_id' => $transaction->transaction_id,
                'admin_user' => Auth::id(),
                'reason' => $reason
            ]);
            
            DB::commit();
            return $payment;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error approving payment', [
                'payment_id' => $payment->payment_id ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Reject payment with reason
     */
    public function rejectPayment(Payment $payment, string $reason)
    {
        try {
            DB::beginTransaction();

            $transaction = $payment->transaction;
            
            // Validate that payment is in pending status
            if ($payment->payment_status !== 'pending') {
                throw new \Exception('Pembayaran tidak dapat ditolak karena status tidak valid.');
            }

            // Update payment status
            $payment->update([
                'payment_status' => 'rejected',
                'rejection_reason' => $reason,
                'rejection_date' => now()
            ]);

            // Update transaction status to dibatalkan and restore stock
            $this->handleCancellation($transaction, $reason);
            $transaction->update(['order_status' => 'dibatalkan']);

            // Log payment rejection
            Log::info('Payment rejected', [
                'payment_id' => $payment->payment_id,
                'transaction_id' => $transaction->transaction_id,
                'admin_user' => Auth::id(),
                'reason' => $reason
            ]);
            
            DB::commit();
            return $payment;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error rejecting payment', [
                'payment_id' => $payment->payment_id ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Handle transaction cancellation and stock restoration
     */
    protected function handleCancellation(Transaction $transaction, string $reason = null)
    {
        try {
            // Restore stock for cancelled transactions
            foreach ($transaction->transactionItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                    
                    Log::info('Stock restored for cancelled transaction', [
                        'product_id' => $product->product_id,
                        'quantity_restored' => $item->quantity,
                        'new_stock' => $product->stock,
                        'transaction_id' => $transaction->transaction_id
                    ]);
                }
            }

            // Log cancellation
            Log::info('Transaction cancelled', [
                'transaction_id' => $transaction->transaction_id,
                'reason' => $reason,
                'admin_user' => Auth::id()
            ]);

        } catch (\Exception $e) {
            Log::error('Error handling transaction cancellation', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Validate status transition
     */
    protected function validateStatusTransition(string $oldStatus, string $newStatus)
    {
        $validTransitions = [
            'menunggu_kode_billing' => ['menunggu_pembayaran', 'dibatalkan'],
            'menunggu_pembayaran' => ['menunggu_konfirmasi_pembayaran', 'dibatalkan'],
            'menunggu_konfirmasi_pembayaran' => ['diproses', 'dibatalkan'],
            'diproses' => ['selesai', 'dibatalkan'],
            'selesai' => [], // Final state
            'dibatalkan' => [] // Final state
        ];

        if (!isset($validTransitions[$oldStatus])) {
            throw new \Exception("Status lama tidak valid: {$oldStatus}");
        }

        if (!in_array($newStatus, $validTransitions[$oldStatus]) && $oldStatus !== $newStatus) {
            throw new \Exception("Transisi status dari '{$oldStatus}' ke '{$newStatus}' tidak diizinkan");
        }
    }

    /**
     * Get transaction statistics for admin dashboard
     */
    public function getTransactionStatistics(array $filters = [])
    {
        $query = Transaction::query();

        // Apply date filters
        if (isset($filters['date_from'])) {
            $query->whereDate('order_date', '>=', $filters['date_from']);
        }
        
        if (isset($filters['date_to'])) {
            $query->whereDate('order_date', '<=', $filters['date_to']);
        }

        return [
            'total_transactions' => $query->count(),
            'pending_payments' => $query->where('order_status', 'menunggu_konfirmasi_pembayaran')->count(),
            'processing' => $query->where('order_status', 'diproses')->count(),
            'completed' => $query->where('order_status', 'selesai')->count(),
            'cancelled' => $query->where('order_status', 'dibatalkan')->count(),
            'total_revenue' => $query->where('order_status', 'selesai')->sum('total_price'),
            'pending_revenue' => $query->whereIn('order_status', ['diproses', 'menunggu_konfirmasi_pembayaran'])->sum('total_price')
        ];
    }

    /**
     * Get transactions that need admin attention
     */
    public function getTransactionsNeedingAttention()
    {
        return Transaction::with(['user', 'payments'])
            ->where('order_status', 'menunggu_konfirmasi_pembayaran')
            ->orderBy('order_date', 'asc')
            ->get();
    }
}
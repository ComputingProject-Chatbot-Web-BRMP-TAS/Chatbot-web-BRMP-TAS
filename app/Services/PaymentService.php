<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PaymentService
{
    /**
     * Upload payment proof for transaction
     */
    public function uploadPaymentProof(Transaction $transaction, $file, string $columnName)
    {
        try {
            DB::beginTransaction();

            // Find or create payment record
            $payment = Payment::firstOrCreate(
                ['transaction_id' => $transaction->transaction_id]
            );
            
            // Store file with proper naming
            $filename = 'bukti_' . time() . '_' . $transaction->transaction_id . '_' . $columnName . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/bukti_pembayaran', $filename);
            
            // Update payment record
            $payment->update([
                $columnName => $filename,
            ]);

            // Check if both payment proofs are uploaded
            $areBothProofsUploaded = $payment->photo_proof_payment_billing !== null && 
                                   $payment->photo_proof_payment_ongkir !== null;
            
            $message = 'Bukti pembayaran berhasil diunggah!';
            
            if ($areBothProofsUploaded) {
                $this->updateTransactionStatusAfterPayment($transaction, $payment);
                $message = 'Kedua bukti pembayaran berhasil diunggah! Status order berubah menjadi "Menunggu Konfirmasi Pembayaran".';
            }

            Log::info('Payment proof uploaded', [
                'payment_id' => $payment->id,
                'transaction_id' => $transaction->transaction_id,
                'filename' => $filename,
                'column' => $columnName,
                'both_uploaded' => $areBothProofsUploaded
            ]);

            DB::commit();
            return [
                'success' => true,
                'message' => $message,
                'payment' => $payment,
                'both_uploaded' => $areBothProofsUploaded
            ];

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to upload payment proof', [
                'transaction_id' => $transaction->transaction_id ?? null,
                'column' => $columnName ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Update transaction status after payment upload
     */
    private function updateTransactionStatusAfterPayment(Transaction $transaction, Payment $payment)
    {
        $transaction->update(['order_status' => 'menunggu_konfirmasi_pembayaran']);
        $payment->update([
            'payment_date' => now('Asia/Jakarta'), 
            'payment_status' => 'pending'
        ]);

        // Clear checkout session
        session()->forget([
            'checkout_cart', 
            'checkout_total', 
            'checkout_shipping_method', 
            'current_transaction_id'
        ]);
    }

    /**
     * Get payment details for transaction
     */
    public function getPaymentDetails(Transaction $transaction)
    {
        return Payment::where('transaction_id', $transaction->transaction_id)->first();
    }

    /**
     * Validate payment proof file
     */
    public function validatePaymentProof($file, string $columnName)
    {
        $allowedColumns = ['photo_proof_payment_billing', 'photo_proof_payment_ongkir'];
        
        if (!in_array($columnName, $allowedColumns)) {
            throw new \Exception('Invalid payment proof type.');
        }

        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file->getSize() > $maxSize) {
            throw new \Exception('File size must be less than 5MB.');
        }

        $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
        $extension = strtolower($file->getClientOriginalExtension());
        
        if (!in_array($extension, $allowedTypes)) {
            throw new \Exception('File must be JPG, PNG, or PDF format.');
        }

        return true;
    }

    /**
     * Delete payment proof file
     */
    public function deletePaymentProof(Payment $payment, string $columnName)
    {
        try {
            if ($payment->$columnName) {
                Storage::delete('public/bukti_pembayaran/' . $payment->$columnName);
                $payment->update([$columnName => null]);
                
                Log::info('Payment proof deleted', [
                    'payment_id' => $payment->id,
                    'column' => $columnName
                ]);
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete payment proof', [
                'payment_id' => $payment->id ?? null,
                'column' => $columnName ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get payment statistics for admin
     */
    public function getPaymentStatistics()
    {
        return [
            'total_payments' => Payment::count(),
            'pending_payments' => Payment::where('payment_status', 'pending')->count(),
            'confirmed_payments' => Payment::where('payment_status', 'confirmed')->count(),
            'rejected_payments' => Payment::where('payment_status', 'rejected')->count(),
            'payments_today' => Payment::whereDate('created_at', now())->count(),
            'payments_this_month' => Payment::whereMonth('created_at', now()->month)->count(),
        ];
    }
}
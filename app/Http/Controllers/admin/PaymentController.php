<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Approve payment
     */
    public function approvePayment(Request $request, $paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $transaction = $payment->transaction;
            
            // Validate that payment is in pending status
            if ($payment->payment_status !== 'pending') {
                return redirect()->back()->with('error', 'Pembayaran tidak dapat dikonfirmasi karena status tidak valid.');
            }
            
            // Update payment status
            $payment->payment_status = 'approved';
            $payment->save();
            
            // Update transaction status to diproses
            $transaction->order_status = 'diproses';
            $transaction->save();
            
            Log::info('Payment approved', [
                'payment_id' => $payment->payment_id,
                'transaction_id' => $transaction->transaction_id,
                'admin_id' => auth()->id()
            ]);
            
            return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi dan pesanan akan diproses');
        } catch (\Exception $e) {
            Log::error('Error approving payment', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengkonfirmasi pembayaran.');
        }
    }
    
    /**
     * Reject payment
     */
    public function rejectPayment(Request $request, $paymentId)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        try {
            $payment = Payment::findOrFail($paymentId);
            $transaction = $payment->transaction;
            
            // Validate that payment is in pending status
            if ($payment->payment_status !== 'pending') {
                return redirect()->back()->with('error', 'Pembayaran tidak dapat ditolak karena status tidak valid.');
            }
            
            // Update payment status
            $payment->payment_status = 'rejected';
            $payment->rejection_reason = $request->rejection_reason;
            $payment->save();
            
            // Update transaction status back to menunggu_pembayaran
            $transaction->order_status = 'menunggu_pembayaran';
            $transaction->save();
            
            Log::info('Payment rejected', [
                'payment_id' => $payment->payment_id,
                'transaction_id' => $transaction->transaction_id,
                'admin_id' => auth()->id(),
                'reason' => $request->rejection_reason
            ]);
            
            return redirect()->back()->with('success', 'Pembayaran ditolak. Customer akan diminta mengirim ulang bukti pembayaran.');
        } catch (\Exception $e) {
            Log::error('Error rejecting payment', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak pembayaran.');
        }
    }
    
    /**
     * View payment details
     */
    public function showPayment($paymentId)
    {
        try {
            $payment = Payment::with(['transaction.user', 'transaction.payments'])->findOrFail($paymentId);
            return view('admin.payment_detail', compact('payment'));
        } catch (\Exception $e) {
            Log::error('Error showing payment', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan.');
        }
    }
} 
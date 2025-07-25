<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Handle POST from cart, store cart in session, redirect to payment page
    public function start(Request $request)
    {
        $cart = $request->input('cart', []);
        session(['cart' => $cart]);
        return redirect()->route('payment.show');
    }

    // Show payment page, retrieve cart from session
    public function show(Request $request)
    {
        $transactionId = session('current_transaction_id');
        
        if (!$transactionId) {
            return redirect()->route('cart')->with('error', 'Silakan checkout ulang dari keranjang.');
        }
        
        // Ambil transaksi dari database
        $transaction = Transaction::with(['transactionItems.product', 'shippingAddress'])->find($transactionId);
        
        if (!$transaction) {
            return redirect()->route('cart')->with('error', 'Transaksi tidak ditemukan.');
        }
        
        // Gunakan alamat dari transaksi jika tersedia, jika tidak gunakan dari session
        $address = $transaction->shippingAddress;
        if (!$address) {
            $addressId = session('checkout_address_id');
            if ($addressId) {
                $address = \App\Models\Address::find($addressId);
            }
        }
        
        $cart = session('checkout_cart', []);
        $total = session('checkout_total', 0);
        $shipping = 0;
        $insurance = 0;
        $grand_total = $total + $shipping + $insurance;
        $deadline = Carbon::parse($transaction->order_date)->addDay()->format('d M Y \\P\\u\\k\\u\\l H:i');
        $shipping_method = session('checkout_shipping_method', 'Standard');

        return view('payment', [
            'transaction' => $transaction,
            'address' => $address,
            'cart' => $cart,
            'total' => $total,
            'shipping' => $shipping,
            'insurance' => $insurance,
            'grand_total' => $grand_total,
            'deadline' => $deadline,
            'shipping_method' => $shipping_method,
        ]);
    }

    // Handle upload bukti pembayaran
    public function uploadProof(Request $request)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);
        
        // Ambil transaction_id dari form atau session
        $transactionId = $request->input('transaction_id') ?? session('current_transaction_id');
        
        if (!$transactionId) {
            return redirect()->route('cart')->with('error', 'Transaksi tidak ditemukan.');
        }
        
        $transaction = Transaction::find($transactionId);
        
        if (!$transaction) {
            return redirect()->route('cart')->with('error', 'Transaksi tidak ditemukan.');
        }
        
        // Cek apakah user yang mengupload adalah pemilik transaksi
        if ($transaction->user_id !== Auth::id()) {
            return redirect()->route('transaksi')->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }
        
        // Cek apakah sudah ada payment untuk transaksi ini yang statusnya BUKAN rejected
        $hasNonRejectedPayment = $transaction->payments()->where('status_payment', '!=', 'rejected')->exists();
        if ($hasNonRejectedPayment) {
            return redirect()->route('transaksi.detail', $transaction->transaction_id)->with('error', 'Bukti pembayaran sudah diupload dan sedang diproses untuk transaksi ini.');
        }
        
        $file = $request->file('bukti_pembayaran');
        $filename = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/bukti_pembayaran', $filename);
        
        // Buat payment baru dengan status 'pending'
        $payment = Payment::create([
            'transaction_id' => $transaction->transaction_id,
            'payment_date' => now('Asia/Jakarta'),
            'amount_paid' => $transaction->total_price,
            'photo_proof_payment' => $filename,
            'status_payment' => 'pending',
        ]);
        
        // Update status order menjadi "menunggu_konfirmasi_pembayaran"
        $transaction->update([
            'status_order' => 'menunggu_konfirmasi_pembayaran'
        ]);
        
        // Bersihkan session checkout jika ada
        session()->forget(['checkout_cart', 'checkout_total', 'checkout_shipping_method', 'current_transaction_id']);
        
        // Redirect ke halaman detail transaksi
        return redirect()->route('transaksi.detail', $transaction->transaction_id)->with('success', 'Bukti pembayaran berhasil diupload! Status order berubah menjadi "Menunggu Konfirmasi Pembayaran".');
    }
}

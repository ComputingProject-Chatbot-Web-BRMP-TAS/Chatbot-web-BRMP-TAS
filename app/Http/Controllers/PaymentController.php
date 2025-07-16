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
        $cart = session('checkout_cart', []);
        $total = session('checkout_total', 0);
        $shipping = 0;
        $insurance = 0;
        $grand_total = $total + $shipping + $insurance;
        $deadline = Carbon::now('Asia/Jakarta')->addDay()->format('d M Y \\P\\u\\k\\u\\l H:i');
        $shipping_method = session('checkout_shipping_method', 'Standard');

        if (empty($cart) || empty($total)) {
            return redirect()->route('cart')->with('error', 'Silakan checkout ulang dari keranjang.');
        }

        return view('payment', [
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
        $file = $request->file('bukti_pembayaran');
        $filename = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/bukti_pembayaran', $filename);
        // Ambil data checkout dari session
        $user = Auth::user();
        $cart = session('checkout_cart', []);
        $total = session('checkout_total', 0);
        $delivery_method = session('checkout_shipping_method', 'Standard');
        $ongkir = 0;
        $asuransi = 0;
        $order_date = Carbon::now('Asia/Jakarta');
        // Tentukan estimasi tanggal pengiriman paling lama
        $estimated_delivery_date = null;
        switch (strtolower($delivery_method)) {
            case 'standard':
                $estimated_delivery_date = $order_date->copy()->addDays(4);
                break;
            case 'kargo':
                $estimated_delivery_date = $order_date->copy()->addDays(7);
                break;
            case 'reguler':
                $estimated_delivery_date = $order_date->copy()->addDays(5);
                break;
            case 'instant':
                $estimated_delivery_date = $order_date;
                break;
            case 'sameday':
                $estimated_delivery_date = $order_date;
                break;
            case 'ekonomi':
                $estimated_delivery_date = $order_date->copy()->addDays(8);
                break;
            default:
                $estimated_delivery_date = $order_date->copy()->addDays(4);
        }
        // Buat transaksi baru
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'order_date' => $order_date,
            'total_harga' => $total + $ongkir + $asuransi,
            'status' => 'pending',
            'delivery_method' => $delivery_method,
            'estimated_delivery_date' => $estimated_delivery_date,
        ]);
        // Buat detail item transaksi
        foreach ($cart as $item) {
            \App\Models\TransactionItem::create([
                'transaction_id' => $transaction->transaksi_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['qty'],
                'unit_price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }
        // Buat payment
        $payment = Payment::create([
            'transaction_id' => $transaction->transaksi_id,
            'payment_date' => now('Asia/Jakarta'),
            'amount_paid' => $transaction->total_harga,
            'photo_proof_payment' => $filename,
            'status' => 'pending',
        ]);
        // Bersihkan session checkout
        session()->forget(['checkout_cart', 'checkout_total', 'checkout_shipping_method', 'current_transaction_id']);
        // Redirect ke halaman detail transaksi
        return redirect()->route('transaksi.detail', $transaction->transaksi_id)->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}

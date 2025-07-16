<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return view('payment', compact('cart', 'total'));
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
        // Simpan info file ke database jika perlu, atau kirim notifikasi, dll.
        return redirect()->route('payment.show')->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}

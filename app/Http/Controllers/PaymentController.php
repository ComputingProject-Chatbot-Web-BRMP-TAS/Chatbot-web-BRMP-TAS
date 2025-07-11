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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)->where('is_primary', true)->first();
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return view('checkout', compact('address', 'cart', 'total'));
    }

    public function next(Request $request)
    {
        // You can process shipping selection here if needed
        return redirect()->route('payment.show');
    }
}

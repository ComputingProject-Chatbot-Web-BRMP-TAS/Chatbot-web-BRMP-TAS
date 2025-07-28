<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Address;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $selectedId = session('checkout_address_id');
        if ($selectedId) {
            $address = Address::where('user_id', $user->user_id)->where('address_id', $selectedId)->first();
        } else {
            $address = Address::where('user_id', $user->user_id)->where('is_primary', true)->first();
        }
        $addresses = Address::where('user_id', $user->user_id)->get();
        // Ambil data cart dari session jika ada
        $cart = session('checkout_cart', []);
        $total = session('checkout_total', 0);
        return view('customer.checkout', compact('address', 'addresses', 'cart', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $checkedItems = json_decode($request->input('checked_items', '[]'), true);

        if (empty($checkedItems)) {
            return redirect()->route('cart')->with('error', 'Pilih minimal satu barang untuk checkout');
        }

        // Cek apakah user sudah punya alamat
        $user = Auth::user();
        $hasAddress = Address::where('user_id', $user->user_id)->exists();
        if (!$hasAddress) {
            // Jangan redirect ke addresses, cukup return error agar frontend bisa handle (tampilkan modal)
            return back()->with('error', 'Silakan tambahkan alamat pengiriman terlebih dahulu sebelum checkout.');
        }

        // Ambil data cart items yang dipilih
        $cartItems = CartItem::whereIn('cart_item_id', $checkedItems)
            ->with('product')
            ->get();

        // Format data untuk session
        $cart = [];
        $total = 0;

        foreach ($cartItems as $item) {
            $cart[] = [
                'cart_item_id' => $item->cart_item_id,
                'product_id' => $item->product->product_id,
                'name' => $item->product->product_name,
                'price' => $item->price_per_unit,
                'quantity' => $item->quantity,
                'subtotal' => $item->price_per_unit * $item->quantity,
                'image' => $item->product->image1,
                'unit' => $item->product->unit
            ];
            $total += $item->price_per_unit * $item->quantity;
        }

        // Simpan ke session
        session(['checkout_cart' => $cart]);
        session(['checkout_total' => $total]);

        return redirect()->route('checkout.show');
    }

    // Set alamat pengiriman untuk checkout (bukan set primary di database, hanya untuk sesi checkout)
    public function setAddress(Request $request, $addressId)
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->user_id)->where('address_id', $addressId)->firstOrFail();
        // Simpan id alamat terpilih ke session
        session(['checkout_address_id' => $address->address_id]);
        // Redirect ke halaman checkout, alamat utama akan diganti dengan alamat terpilih
        return redirect()->route('checkout.show');
    }

    public function next(Request $request)
    {
        $user = Auth::user();
        $cart = session('checkout_cart', []);
        $total = session('checkout_total', 0);
        $shipping_method = $request->input('shipping_method', 'reguler');

        // Validasi data checkout
        if (empty($cart) || empty($total)) {
            return redirect()->route('cart')->with('error', 'Silakan checkout ulang dari keranjang.');
        }

        // Validasi shipping method
        if (empty($shipping_method)) {
            return redirect()->back()->with('error', 'Silakan pilih metode pengiriman.');
        }

        // Validasi form kepentingan
        $purchase_purpose = $request->input('purchase_purpose');
        $province = $request->input('province');
        $city = $request->input('city');

        if (empty($purchase_purpose) || empty($province) || empty($city)) {
            return redirect()->back()->with('error', 'Tolong lengkapi data terlebih dahulu.');
        }

        // Cek apakah user sudah punya alamat
        $selectedId = session('checkout_address_id');
        if ($selectedId) {
            $address = Address::where('user_id', $user->user_id)->where('address_id', $selectedId)->first();
        } else {
            $address = Address::where('user_id', $user->user_id)->where('is_primary', true)->first();
        }

        if (!$address) {
            return redirect()->route('addresses')->with('error', 'Silakan pilih alamat pengiriman terlebih dahulu.');
        }

        // Hitung ongkir dan asuransi (untuk sementara 0)
        $ongkir = 0;
        $asuransi = 0;
        $order_date = Carbon::now('Asia/Jakarta');

        // Tentukan estimasi tanggal pengiriman berdasarkan metode pengiriman
        $estimated_delivery_date = null;
        switch ($shipping_method) {
            case 'reguler':
                $estimated_delivery_date = $order_date->copy()->addDays(5);
                break;
            case 'kargo':
                $estimated_delivery_date = $order_date->copy()->addDays(7);
                break;
            case 'pickup':
                $estimated_delivery_date = $order_date;
                break;
        }

        // Buat transaksi baru dengan status 'menunggu_pembayaran'
        $transaction = Transaction::create([
            'user_id' => $user->user_id,
            'shipping_address_id' => $address->address_id,
            'recipient_name' => $address->recipient_name,
            'shipping_address' => $address->address,
            'recipient_phone' => $address->recipient_phone,
            'shipping_note' => $address->note,
            'purchase_purpose' => $purchase_purpose,
            'province_id' => $province,
            'regency_id' => $city,
            'order_date' => $order_date,
            'total_price' => $total + $ongkir + $asuransi,
            'order_status' => 'menunggu_pembayaran',
            'delivery_method' => $shipping_method ?? 'reguler', // Pastikan tidak null
            'estimated_delivery_date' => $estimated_delivery_date,
        ]);

        // Buat detail item transaksi
        foreach ($cart as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->transaction_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Hapus item dari cart setelah transaksi dibuat
        $cartItemIds = collect($cart)->pluck('cart_item_id')->toArray();
        CartItem::whereIn('cart_item_id', $cartItemIds)->delete();

        // Simpan data ke session untuk halaman payment
        session(['checkout_shipping_method' => $shipping_method]);
        session(['current_transaction_id' => $transaction->transaction_id]);

        // Redirect ke halaman payment
        return redirect()->route('payment.show')->with('success', 'Transaksi berhasil dibuat! Silakan lakukan pembayaran.');
    }
}

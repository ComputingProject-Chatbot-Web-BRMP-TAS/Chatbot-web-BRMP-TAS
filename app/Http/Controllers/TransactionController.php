<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // Ambil transaksi user beserta item dan produk
        $transactions = \App\Models\Transaction::where('user_id', $user->id)
            ->with(['transactionItems.product'])
            ->orderByDesc('order_date')
            ->get();
        return view('transaksi', compact('transactions'));
    }

    public function detail($id)
    {
        $user = Auth::user();
        $transaction = \App\Models\Transaction::with(['transactionItems.product', 'payments'])
            ->where('user_id', $user->id)
            ->where('transaksi_id', $id)
            ->firstOrFail();
        return view('transaksi_detail', compact('transaction'));
    }
} 
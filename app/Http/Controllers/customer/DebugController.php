<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;

class DebugController extends Controller
{
    public function transactions()
    {
        $transactions = Transaction::with(['transactionItems.product', 'payments'])->get();
        return response()->json($transactions);
    }

    public function transactionItems()
    {
        return response()->json(TransactionItem::with('product')->get());
    }

    public function payments()
    {
        return response()->json(Payment::all());
    }
} 
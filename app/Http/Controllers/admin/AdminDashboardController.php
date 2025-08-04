<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    
    public function transactions(Request $request)
    {
        $query = Transaction::with(['user', 'transactionItems.product', 'payments']);
        
        // Filter by order status
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        
        // Filter by payment status
        if ($request->filled('payment_status')) {
            if ($request->payment_status == 'no_payment') {
                $query->whereDoesntHave('payments');
            } else {
                $query->whereHas('payments', function($q) use ($request) {
                    $q->where('payment_status', $request->payment_status);
                });
            }
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('order_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }
        
        $transactions = $query->orderBy('order_date', 'desc')->get();
        return view('admin.transactions', compact('transactions'));
    }
    
    public function transactionDetail($id)
    {
        $transaction = Transaction::with(['user', 'transactionItems.product', 'payments', 'shippingAddress', 'province', 'regency'])
            ->where('transaction_id', $id)
            ->firstOrFail();
        return view('admin.transaction_detail', compact('transaction'));
    }
    
    public function updateTransactionStatus(Request $request, $id)
    {
        $transaction = Transaction::where('transaction_id', $id)->firstOrFail();
        $transaction->order_status = $request->status;
        $transaction->save();
        
        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui');
    }
    
    public function articles()
    {
        // Untuk sementara, kita akan menggunakan view yang sama dengan dashboard
        // karena belum ada model Article
        return view('admin.articles');
    }
} 
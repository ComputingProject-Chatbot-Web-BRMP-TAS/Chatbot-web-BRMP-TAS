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
        
        // Ambil parameter filter
        $search = $request->input('search');
        $status = $request->input('status');
        
        // Query dasar
        $query = Transaction::where('user_id', $user->id)
            ->with(['transactionItems.product', 'payments']);
        
        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                // Cari pada nama produk
                $q->whereHas('transactionItems.product', function($q2) use ($search) {
                    $q2->whereRaw('LOWER(product_name) LIKE ?', ['%' . strtolower($search) . '%']);
                })
                // Cari pada transaksi_id
                ->orWhere('transaction_id', 'like', "%$search%")
                // Cari pada order_date (format yyyy-mm-dd atau d M Y)
                ->orWhere('order_date', 'like', "%$search%")
                // Cari pada total_price
                ->orWhere('total_price', 'like', "%$search%")
                ;
            });
        }
        
        // Filter berdasarkan status
        if ($status && $status !== 'semua') {
            switch ($status) {
                case 'berlangsung':
                    $query->whereIn('status_order', [
                        'menunggu_pembayaran',
                        'menunggu_konfirmasi_pembayaran',
                        'diproses',
                        'dikirim'
                    ]);
                    break;
                case 'selesai':
                    $query->where('status_order', 'selesai');
                    break;
                case 'tidak_berhasil':
                    $query->where('status_order', 'dibatalkan');
                    break;
                case 'menunggu_pembayaran':
                    $query->where('status_order', 'menunggu_pembayaran');
                    break;
                case 'menunggu_konfirmasi':
                    $query->where('status_order', 'menunggu_konfirmasi_pembayaran');
                    break;
            }
        }
        
        // Ambil transaksi user beserta item dan produk
        $transactions = $query->orderByDesc('order_date')->orderByDesc('transaction_id')->get();
        
        return view('transaksi', compact('transactions', 'search', 'status'));
    }

    public function detail($id)
    {
        $user = Auth::user();
        $transaction = \App\Models\Transaction::with(['transactionItems.product', 'payments', 'shippingAddress'])
            ->where('user_id', $user->id)
            ->where('transaction_id', $id)
            ->firstOrFail();
        return view('transaksi_detail', compact('transaction'));
    }
} 
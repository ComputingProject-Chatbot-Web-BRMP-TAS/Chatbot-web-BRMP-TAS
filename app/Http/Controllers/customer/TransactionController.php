<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ambil parameter filter
        $search = $request->input('search');
        $status = $request->input('status');
        
        // Query dasar
        $query = Transaction::where('user_id', $user->user_id)
            ->with(['transactionItems.product', 'payments']);
        
        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                // Cari pada nama produk
                $q->whereHas('transactionItems.product', function($q2) use ($search) {
                    $q2->whereRaw('LOWER(product_name) LIKE ?', ['%' . strtolower($search) . '%']);
                })
                // Cari pada transaction_id
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
                    $query->whereIn('order_status', ['menunggu_kode_billing',
                        'menunggu_pembayaran',
                        'menunggu_konfirmasi_pembayaran',
                        'diproses'
                    ]);
                    break;
                case 'selesai':
                    $query->where('order_status', 'selesai');
                    break;
                case 'tidak_berhasil':
                    $query->where('order_status', 'dibatalkan');
                    break;
                case 'menunggu_kode_billing':
                    $query->where('order_status', 'menunggu_kode_billing');
                    break;
                case 'menunggu_pembayaran':
                    $query->where('order_status', 'menunggu_pembayaran');
                    break;
                case 'menunggu_konfirmasi':
                    $query->where('order_status', 'menunggu_konfirmasi_pembayaran');
                    break;
            }
        }
        
        // Ambil transaksi user beserta item dan produk
        $transactions = $query->orderByDesc('order_date')->orderByDesc('transaction_id')->get();
        
        return view('customer.transaksi', compact('transactions', 'search', 'status'));
    }

    public function detail($id)
    {
        $user = Auth::user();
        $transaction = Transaction::with([
            'transactionItems.product', 
            'payments', 
            'shippingAddress'
        ])
            ->where('user_id', $user->user_id)
            ->where('transaction_id', $id)
            ->firstOrFail();
        return view('customer.transaksi_detail', compact('transaction'));
    }

    public function viewInvoice($id)
    {
        $user = Auth::user();
        $transaction = Transaction::with(['transactionItems.product', 'payments', 'shippingAddress'])
            ->where('user_id', $user->user_id)
            ->where('transaction_id', $id)
            ->firstOrFail();

        return view('customer.invoice_pdf', [
            'transaction' => $transaction,
            'isPdf' => false
        ]);
    }

    public function downloadInvoice($id)
    {
        $user = Auth::user();
        $transaction = Transaction::with(['transactionItems.product', 'payments', 'shippingAddress'])
            ->where('user_id', $user->user_id)
            ->where('transaction_id', $id)
            ->firstOrFail();

        $pdf = Pdf::loadView('customer.invoice_pdf', [
            'transaction' => $transaction,
            'isPdf' => true
        ]);
        return $pdf->download('kuitansi_'.$transaction->transaction_id.'.pdf');
    }
} 
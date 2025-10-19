<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use App\Services\AdminTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminTransactionController extends Controller
{
    protected $adminTransactionService;

    public function __construct(AdminTransactionService $adminTransactionService)
    {
        $this->adminTransactionService = $adminTransactionService;
    }

    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'transactionItems.product', 'payments']);
        
        // Filter by order status
        if ($request->filled('order_status')) {
            $query->where('order_status', $request->order_status);
        }
        
        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->whereHas('payments', function($q) use ($request) {
                $q->where('payment_status', $request->payment_status);
            });
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('order_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }
        
        $transactions = $query->orderBy('order_date', 'desc')->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'transactionItems.product', 'payments', 'shippingAddress', 'province', 'regency'])
            ->where('transaction_id', $id)
            ->firstOrFail();
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Update transaction status using service
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $newStatus = $request->input('status');
            $reason = $request->input('reason');

            $this->adminTransactionService->updateTransactionStatus($transaction, $newStatus, $reason);
            
            return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Approve payment using service
     */
    public function approvePayment(Request $request, $paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $reason = $request->input('reason');
            
            $this->adminTransactionService->approvePayment($payment, $reason);
            
            return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi dan pesanan akan diproses');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Reject payment using service
     */
    public function rejectPayment(Request $request, $paymentId)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        try {
            $payment = Payment::findOrFail($paymentId);
            $reason = $request->rejection_reason;
            
            $this->adminTransactionService->rejectPayment($payment, $reason);
            
            return redirect()->back()->with('success', 'Pembayaran berhasil ditolak.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Dashboard statistics
     */
    public function dashboard(Request $request)
    {
        $filters = [
            'date_from' => $request->date_from,
            'date_to' => $request->date_to
        ];

        $statistics = $this->adminTransactionService->getTransactionStatistics($filters);
        $pendingTransactions = $this->adminTransactionService->getTransactionsNeedingAttention();

        return view('admin.dashboard', compact('statistics', 'pendingTransactions'));
    }

    /**
     * Export transactions to PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $query = Transaction::with(['user', 'transactionItems.product', 'payments']);
            
            // Apply filters
            if ($request->filled('order_status')) {
                $query->where('order_status', $request->order_status);
            }
            
            if ($request->filled('start_date')) {
                $query->whereDate('order_date', '>=', $request->start_date);
            }
            
            if ($request->filled('end_date')) {
                $query->whereDate('order_date', '<=', $request->end_date);
            }
            
            $transactions = $query->orderBy('order_date', 'desc')->get();
            
            $pdf = Pdf::loadView('admin.transactions.export-pdf', compact('transactions'));
            
            return $pdf->download('transactions_export_' . now()->format('Y_m_d') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal export data: ' . $e->getMessage());
        }
    }

    /**
     * Get transaction details for modal/ajax
     */
    public function getTransactionDetails($id)
    {
        try {
            $transaction = Transaction::with(['user', 'transactionItems.product', 'payments'])
                ->where('transaction_id', $id)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $transaction
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
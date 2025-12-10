<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use App\Services\AdminTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
     * Show invoice view for a transaction (HTML)
     */
    public function viewInvoice($id)
    {
        $transaction = Transaction::with(['user', 'transactionItems.product', 'shippingAddress', 'province', 'regency', 'payments'])
            ->where('transaction_id', $id)
            ->firstOrFail();

        return view('admin.transactions.invoice_pdf', [
            'transaction' => $transaction,
            'isPdf' => false,
        ]);
    }

    /**
     * Download invoice as PDF
     */
    public function downloadInvoice($id)
    {
        try {
            $transaction = Transaction::with(['user', 'transactionItems.product', 'shippingAddress', 'province', 'regency', 'payments'])
                ->where('transaction_id', $id)
                ->firstOrFail();

            $data = [
                'transaction' => $transaction,
                'isPdf' => true,
            ];

            $pdf = Pdf::loadView('admin.transactions.invoice_pdf', $data)->setPaper('A4', 'portrait');

            $filename = 'invoice_' . $transaction->transaction_id . '_' . now()->format('Ymd_His') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Failed to generate/download invoice: ' . $e->getMessage(), ['transaction_id' => $id]);
            return redirect()->back()->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    /**
     * Update shipment tracking number (no_resi) for a transaction
     */
    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'no_resi' => 'required|string|max:255',
        ]);

        try {
            $transaction = Transaction::findOrFail($id);

            $old = $transaction->no_resi;
            $transaction->no_resi = $request->input('no_resi');
            // When a shipment tracking number is set, mark the order as completed ('selesai')
            // meaning the order has been shipped. Also set the done_date timestamp.
            $transaction->order_status = 'selesai';
            $transaction->done_date = now();
            $transaction->save();

            Log::info('updateResi saved', [
                'transaction_id' => $id,
                'old_no_resi' => $old,
                'new_no_resi' => $transaction->no_resi,
            ]);

            return redirect()->back()->with('success', 'Nomor resi berhasil disimpan dan status pesanan diubah menjadi selesai.');

        } catch (\Exception $e) {
            Log::error('Failed to update resi: ' . $e->getMessage(), ['transaction_id' => $id]);
            return redirect()->back()->with('error', 'Gagal menyimpan nomor resi: ' . $e->getMessage());
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

    /**
     * Show billing input form for a transaction
     */
    public function showBillingForm($id)
    {
        $transaction = Transaction::with(['user', 'transactionItems.product', 'payments'])
            ->where('transaction_id', $id)
            ->firstOrFail();

        return view('admin.transactions.billing', compact('transaction'));
    }

    /**
     * Store billing files and ongkir as a Payment record and update transaction
     */
    public function storeBilling(Request $request, $id)
    {
        // Validate input and files
        $validator = Validator::make($request->all(), [
            'billing_code_file' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'no_rek_ongkir' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'total_ongkir' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            Log::info('storeBilling validation failed', [
                'transaction_id' => $id,
                'errors' => $validator->errors()->all(),
            ]);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $transaction = Transaction::findOrFail($id);

            Log::info('storeBilling received request', [
                'transaction_id' => $id,
                'has_billing_file' => $request->hasFile('billing_code_file'),
                'has_rek_file' => $request->hasFile('no_rek_ongkir'),
                'total_ongkir' => $request->input('total_ongkir'),
            ]);

            // store files on public disk so files are accessible via asset('storage/...')
            $billingPath = $request->file('billing_code_file')->store('billing_codes', 'public');
            $rekOngkirPath = $request->file('no_rek_ongkir')->store('rek_ongkir_files', 'public');

            // create a payment record to track billing/ongkir submission
            $payment = Payment::create([
                'transaction_id' => $transaction->transaction_id,
                'payment_date' => now(),
                'billing_code_file' => $billingPath,
                'no_rek_ongkir' => $rekOngkirPath,
                'payment_status' => 'no_payment',
            ]);

            // update transaction total ongkir if provided
            $transaction->total_ongkir = $request->input('total_ongkir');
            // update order_status to waiting for payment
            $transaction->order_status = 'menunggu_pembayaran';
            $transaction->save();

            Log::info('storeBilling saved payment and updated transaction', [
                'payment_id' => $payment->payment_id ?? null,
                'transaction_id' => $transaction->transaction_id,
            ]);

            return redirect()->route('admin.transactions.show', $transaction->transaction_id)
                ->with('success', 'Billing dan ongkir berhasil disimpan.');

        } catch (\Exception $e) {
            Log::error('Failed to store billing: ' . $e->getMessage(), [
                'transaction_id' => $id,
            ]);
            return redirect()->back()->with('error', 'Gagal menyimpan billing: ' . $e->getMessage());
        }
    }
}
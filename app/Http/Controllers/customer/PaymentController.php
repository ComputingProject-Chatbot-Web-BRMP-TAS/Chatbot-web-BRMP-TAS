<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    /**
     * Handle upload bukti pembayaran untuk billing atau ongkir.
     * Status transaksi hanya akan berubah setelah kedua file diunggah.
     */
    public function uploadProof(Request $request)
    {
        $request->validate([
            'bukti_pembayaran_billing' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'bukti_pembayaran_ongkir' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'transaction_id' => 'required|exists:transactions,transaction_id'
        ]);
        
        try {
            // Tentukan file mana yang diunggah dan nama kolomnya
            if ($request->hasFile('bukti_pembayaran_billing')) {
                $file = $request->file('bukti_pembayaran_billing');
                $columnName = 'photo_proof_payment_billing';
            } elseif ($request->hasFile('bukti_pembayaran_ongkir')) {
                $file = $request->file('bukti_pembayaran_ongkir');
                $columnName = 'photo_proof_payment_ongkir';
            } else {
                return redirect()->back()->with('error', 'Tidak ada file yang diunggah.');
            }

            $transactionId = $request->input('transaction_id') ?? session('current_transaction_id');
            
            // Validasi Transaksi dan Kepemilikan
            $transaction = Transaction::find($transactionId);
            if (!$transaction || $transaction->user_id !== Auth::id()) {
                return redirect()->route('transaksi')->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
            }
            
            if ($transaction->order_status !== 'menunggu_pembayaran') {
                return redirect()->route('transaksi.detail', $transaction->transaction_id)
                    ->with('error', 'Transaksi tidak dapat menerima pembayaran karena status tidak valid.');
            }

            // Validasi file menggunakan service
            $this->paymentService->validatePaymentProof($file, $columnName);

            // Upload bukti pembayaran menggunakan service
            $result = $this->paymentService->uploadPaymentProof($transaction, $file, $columnName);

            return redirect()->route('transaksi.detail', $transaction->transaction_id)
                ->with('success', $result['message']);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal upload bukti pembayaran: ' . $e->getMessage());
        }
    }
}

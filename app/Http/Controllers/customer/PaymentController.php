<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
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
                return redirect()->route('transaksi.detail', $transaction->transaction_id)->with('error', 'Transaksi tidak dapat menerima pembayaran karena status tidak valid.');
            }

            // Cari record pembayaran yang sudah ada untuk transaksi ini
            $payment = Payment::firstOrCreate(
                ['transaction_id' => $transaction->transaction_id]
            );
            
            // Simpan file dan perbarui record pembayaran
            $filename = 'bukti_' . time() . '_' . $transaction->transaction_id . '_' . $columnName . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/bukti_pembayaran', $filename);
            
            $payment->update([
                $columnName => $filename,
            ]);

            // Periksa apakah kedua bukti pembayaran sudah diunggah
            $areBothProofsUploaded = $payment->photo_proof_payment_billing !== null && $payment->photo_proof_payment_ongkir !== null;
            
            $successMessage = 'Bukti pembayaran berhasil diunggah!';
            
            if ($areBothProofsUploaded) {
                // Jika kedua bukti sudah diunggah, perbarui status transaksi
                $transaction->update(['order_status' => 'menunggu_konfirmasi_pembayaran']);
                $payment->update(['payment_date' => now('Asia/Jakarta'), 'payment_status' => 'pending']);
                session()->forget(['checkout_cart', 'checkout_total', 'checkout_shipping_method', 'current_transaction_id']);
                $successMessage = 'Kedua bukti pembayaran berhasil diunggah! Status order berubah menjadi "Menunggu Konfirmasi Pembayaran".';
            }

            Log::info('Payment proof uploaded', [
                'payment_id' => $payment->id,
                'transaction_id' => $transaction->transaction_id,
                'user_id' => Auth::id(),
                'filename' => $filename,
                'column' => $columnName,
                'status_updated' => $areBothProofsUploaded
            ]);
            
            return redirect()->route('transaksi.detail', $transaction->transaction_id)->with('success', $successMessage);

        } catch (\Exception $e) {
            Log::error('Error uploading payment proof', [
                'transaction_id' => $request->input('transaction_id'),
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran. Silakan coba lagi.');
        }
    }
}

<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\ComplaintService;

class ComplaintController extends Controller
{
    protected $complaintService;

    public function __construct(ComplaintService $complaintService)
    {
        $this->complaintService = $complaintService;
    }
    public function create()
    {
        $transactions = \App\Models\Transaction::where('user_id', Auth::id())->orderByDesc('created_at')->get();

        // Hanya ambil transaksi selesai dalam 30 hari terakhir
        $finishedTransactions = \App\Models\Transaction::where('user_id', Auth::id())
            ->where('order_status', 'selesai')
            ->where('done_date', '>=', now()->subDays(30))
            ->orderByDesc('created_at')
            ->get();

        return view('customer.form_complaint', compact('transactions', 'finishedTransactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,transaction_id',
            'nomor_kantong' => 'required|numeric',
            'description' => 'required|string|max:1000',
            'photo_proof' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        try {
            // Validate data using service
            $this->complaintService->validateComplaintData($validated);

            // Create complaint using service
            $this->complaintService->createComplaint(
                Auth::user(), 
                $validated, 
                $request->file('photo_proof')
            );

            return redirect('/')->with('success', 'Komplain berhasil dikirim! Tim kami akan menghubungi Anda melalui WhatsApp untuk menangani masalah ini.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengirim komplain: ' . $e->getMessage());
        }
    }
} 
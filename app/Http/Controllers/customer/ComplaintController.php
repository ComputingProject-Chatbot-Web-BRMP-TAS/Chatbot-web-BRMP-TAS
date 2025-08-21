<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ComplaintController extends Controller
{
    public function create()
    {
        $transactions = \App\Models\Transaction::where('user_id', Auth::id())->orderByDesc('created_at')->get();
        $finishedTransactions = \App\Models\Transaction::where('user_id', Auth::id())->where('order_status', 'selesai')->orderByDesc('created_at')->get();
        return view('customer.form_complaint', compact('transactions', 'finishedTransactions'));

        return view('customer.form_complaint');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'complaint_types' => 'required|string',
            'transaction_id' => 'required|exists:transactions,transaction_id',
            'description' => 'required|string|max:1000',
            'photo_proof' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $validated['photo_proof'] = $request->file('photo_proof')->store('bukti_komplain', 'public');
        $validated['user_id'] = Auth::id();
        
        Complaint::create($validated);
        
        return redirect('/')->with('success', 'Komplain berhasil dikirim! Tim kami akan menghubungi Anda melalui WhatsApp untuk menangani masalah ini.');
    }
} 
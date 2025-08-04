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
        return view('customer.form_complaint');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'photo_proof' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $validated['photo_proof'] = $request->file('photo_proof')->store('bukti_komplain', 'public');
        $validated['user_id'] = Auth::id();
        
        Complaint::create($validated);
        
        return redirect('/')->with('success', 'Komplain berhasil dikirim! Tim kami akan menghubungi Anda melalui WhatsApp untuk menangani masalah ini.');
    }
} 
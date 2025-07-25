<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function create()
    {
        return view('complaint.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'photo_proof' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);
        $validated['photo_proof'] = $request->file('photo_proof')->store('bukti_komplain', 'public');
        $validated['user_id'] = Auth::id();
        Complaint::create($validated);
        return redirect()->back()->with('success', 'Komplain berhasil dikirim! Balasan komplain akan dikirim melalui Whatsapp');
    }
} 
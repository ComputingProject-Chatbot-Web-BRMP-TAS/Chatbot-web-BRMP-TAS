<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Dummy data transaksi, nanti bisa diganti dengan query ke database
        $user = Auth::user();
        $transactions = [
            // Contoh transaksi
            [
                'id' => 1,
                'date' => '2025-07-11',
                'status' => 'Selesai',
                'product' => 'Benih Cabai Rawit',
                'qty' => 2,
                'total' => 50000,
                'image' => null,
            ],
            [
                'id' => 2,
                'date' => '2025-07-10',
                'status' => 'Berlangsung',
                'product' => 'Benih Tomat',
                'qty' => 1,
                'total' => 25000,
                'image' => null,
            ],
        ];
        return view('transaksi', compact('transactions'));
    }
} 
<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Complaint;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    

    
    public function transactions()
    {
        $transactions = Transaction::with(['user', 'items.product'])->orderBy('created_at', 'desc')->get();
        return view('admin.transactions', compact('transactions'));
    }
    
    public function articles()
    {
        // Untuk sementara, kita akan menggunakan view yang sama dengan dashboard
        // karena belum ada model Article
        return view('admin.articles');
    }
} 
<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Http\Controllers\Controller;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.complaints.index', compact('complaints'));
    }

    public function show($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);
        return view('admin.complaints.show', compact('complaint'));
    }

    public function dashboard()
    {
        $totalComplaints = Complaint::count();
        $recentComplaints = Complaint::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.complaints.dashboard', compact('totalComplaints', 'recentComplaints'));
    }
} 
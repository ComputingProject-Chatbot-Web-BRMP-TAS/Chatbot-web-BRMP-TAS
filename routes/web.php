<?php

// =====================
// Import & Dependency
// =====================
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customer\DebugController;

// =====================
// INCLUDE ROLE-BASED ROUTES
// =====================
require __DIR__.'/guest.php';
require __DIR__.'/customer.php';
require __DIR__.'/admin.php';

// =====================
// API ROUTES
// =====================
Route::get('/api/wilayah/cities/{provinceId}', function ($provinceId) {
    $cities = \App\Models\RegRegencies::where('province_id', $provinceId)
        ->orderBy('name')
        ->get(['id', 'name']);
    return response()->json($cities);
});

// =====================
// DEBUG & DEV TOOLS (Development Only)
// =====================
if (app()->environment('local')) {
    Route::get('/debug/transactions', [DebugController::class, 'transactions']);
    Route::get('/debug/transaction-items', [DebugController::class, 'transactionItems']);
    Route::get('/debug/payments', [DebugController::class, 'payments']);
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

// =====================
// CHATBOT API
// =====================


// =====================
// WILAYAH API
// =====================
Route::get('/wilayah/cities/{provinceId}', function ($provinceId) {
    $cities = \App\Models\RegRegencies::where('province_id', $provinceId)
        ->orderBy('name')
        ->get(['id', 'name']);
    return response()->json($cities);
});

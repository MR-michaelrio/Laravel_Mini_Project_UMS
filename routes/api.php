<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PelangganController, BarangController, PenjualanController};

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});
Route::apiResource('pelanggans', PelangganController::class);
Route::apiResource('barangs', BarangController::class);
Route::apiResource('penjualans', PenjualanController::class);


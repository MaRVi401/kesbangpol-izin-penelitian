<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Mahasiswa\ApiServiceController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    // Jalur untuk logout pengguna yang sudah login
    Route::post('/logout', [AuthController::class, 'logout']);

    // Endpoint untuk Submit Izin Penelitian
    Route::post('/services/store', [ApiServiceController::class, 'store']);

    // Endpoint untuk Autosave Draft
    Route::post('/services/autosave', [ApiServiceController::class, 'autosave']);
});

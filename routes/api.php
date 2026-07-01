<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Mahasiswa\ApiServiceController;
use App\Http\Controllers\Api\ApiProfileController;
use App\Http\Controllers\Api\Mahasiswa\ApiServiceHistoryTicketController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    // Jalur untuk logout pengguna yang sudah login
    Route::post('/logout', [AuthController::class, 'logout']);

    // Endpoint untuk Submit Izin Penelitian
    Route::post('/services/store', [ApiServiceController::class, 'store']);

    // Endpoint untuk Autosave Draft
    Route::post('/services/autosave', [ApiServiceController::class, 'autosave']);

    // Endpoint untuk menampilkan data profil pengguna
    Route::get('/profile', [ApiProfileController::class, 'show']);

    // Endpoint untuk memperbarui data profil pengguna
    Route::post('/profile/updated', [ApiProfileController::class, 'update']);

    // Ambil daftar riwayat tiket
    Route::get('/tickets', [ApiServiceHistoryTicketController::class, 'index']);
    
    // Aksi pengajuan revisi
    Route::post('/tickets/{uuid}/revisi', [ApiServiceHistoryTicketController::class, 'revisi']);
    
    // Unduh dokumen PDF TTE final
    Route::get('/tickets/{uuid}/download', [ApiServiceHistoryTicketController::class, 'downloadSignedDocument']);
});

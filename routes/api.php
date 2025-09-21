<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['status' => 'ok', 'database' => 'connected']);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'database' => 'not connected',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Nota: /sanctum/csrf-cookie lo expone Sanctum automáticamente (GET) vía middleware "web".
// En SPA, primero golpeás /sanctum/csrf-cookie y luego /login.

// === AUTH PROTEGIDO (requiere cookie de sesión Sanctum) ===
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', fn(Request $r) => $r->user());
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy']);
    // tus endpoints protegidos...
});

// === AUTH PÚBLICO ===
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);





   

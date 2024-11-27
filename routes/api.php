<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

// USUÁRIO
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/2fa/verify', [UserController::class, 'verify']);
    Route::post('/password/forgot', [UserController::class, 'forgotPassword']);
    Route::post('/password/reset', [UserController::class, 'resetPassword']);
    Route::post('/login', [UserController::class, 'login']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

// AUTENTICAÇÃO
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/validate-token', [AuthController::class, 'validateToken']);
});

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello World']);
});

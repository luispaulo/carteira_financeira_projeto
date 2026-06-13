<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;

Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class,'me']);
    Route::post('/logout', [AuthController::class,'logout']);

    //wallet 
    Route::get('/wallet', [WalletController::class, 'show']);

    //transactions
    Route::get('/transactions', [TransactionController::class, 'index']);
});
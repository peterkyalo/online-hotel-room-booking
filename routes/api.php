<?php

use App\Http\Controllers\Front\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/mpesa/generate-token', [PaymentController::class, 'generateAccessToken'])->name('generate_token');
// Route::get('/mpesa/generate-password', [PaymentController::class, 'lipaNaMpesaPassword'])->name('generate_password');
// Route::post('/mpesa/stk-push', [PaymentController::class, 'customerMpesaSTKPush'])->name('stk_push');
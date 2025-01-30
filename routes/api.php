<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
 * @Auth Routes
 */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
	Route::post('/email-verification', [EmailVerificationController::class, 'email_verification']);
	Route::get('/resend-otp', [EmailVerificationController::class, 'resend_otp']);
	Route::post('/logout', [AuthController::class, 'logout']);
});

/**
 * @Resource Routes
 */
Route::apiResource('posts', PostController::class);
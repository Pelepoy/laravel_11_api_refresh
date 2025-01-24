<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * @Resource Routes
 */
Route::apiResource('posts', PostController::class);
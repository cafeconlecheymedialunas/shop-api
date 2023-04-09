<?php

use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('colors', ColorController::class)->names('colors');
    Route::apiResource('tags', TagController::class)->names('tags');
    Route::apiResource('posts', PostController::class)->names('posts');
    Route::apiResource('products', ProductController::class)->names('products');
    Route::apiResource('profiles', ProfileController::class)->names('profiles');
    Route::apiResource('coupons', CouponController::class)->names('coupons');
});

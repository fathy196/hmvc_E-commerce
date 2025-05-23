<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Http\Controllers\CategoryController;
use Modules\User\Http\Controllers\OrderController;
use Modules\User\Http\Controllers\PaymentController;
use Modules\User\Http\Controllers\ProductController;
use Modules\User\Http\Controllers\UserController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class)->names('user');

Route::get('categories', [CategoryController::class, 'index']);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

 Route::post('orders', [OrderController::class, 'store']);
Route::post('/checkout/{order_id}', [PaymentController::class, 'checkout']);
});



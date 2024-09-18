<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::apiResource('orders', OrderController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('users',UserController::class);
Route::get('/', 
function () {
    return 'api';
    });

Route::get('/users/{id}/products', [UserController::class, 'getUserProducts']);
Route::get('/buyers', [UserController::class, 'buyers']);




<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SalesOrderApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
|
*/



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::apiResource('products', ProductApiController::class);

    Route::post('/sales-orders', [SalesOrderApiController::class, 'store'])->name('api.sales-orders.store');
    Route::get('/sales-orders', [SalesOrderApiController::class, 'index'])->name('api.sales-orders.index');
    Route::get('/sales-orders/{order}', [SalesOrderApiController::class, 'show'])->name('api.sales-orders.show');
});
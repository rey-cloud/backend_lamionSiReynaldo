<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('orders', [OrderController::class, 'index']); 
Route::post('orders', [OrderController::class, 'create']); 
Route::get('orders/{id}', [OrderController::class, 'read']);
Route::put('orders/{id}', [OrderController::class, 'update']);
Route::delete('orders/{id}', [OrderController::class, 'delete']);

Route::get('order_detail', [OrderDetailController::class, 'index']); 
Route::post('order_detail', [OrderDetailController::class, 'create']); 
Route::get('order_detail/{id}', [OrderDetailController::class, 'read']);
Route::put('order_detail/{id}', [OrderDetailController::class, 'update']);
Route::delete('order_detail/{id}', [OrderDetailController::class, 'delete']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::patch('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);
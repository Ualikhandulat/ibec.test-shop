<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::apiResource('catalogs', CatalogController::class)->only('index', 'store');
        Route::apiResource('products', ProductController::class)->only('index', 'store');
    });

});

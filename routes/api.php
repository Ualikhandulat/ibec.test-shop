<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SpecificationController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('catalogs', [CatalogController::class, 'index']);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product:slug}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {


    // администратор
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::post('catalogs', [CatalogController::class, 'store']);
        Route::post('products', [ProductController::class, 'store']);

        Route::apiResource('specifications', SpecificationController::class)->only('index', 'store');
    });

});

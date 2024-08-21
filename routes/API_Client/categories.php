<?php

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


Route::prefix('categories')->group(function () {
    Route::get('/', [\App\Http\Controllers\CategoryController::class, 'indexCategory']);
    Route::post('/', [\App\Http\Controllers\CategoryController::class, 'storeCategory']);
    Route::put('/{id}', [\App\Http\Controllers\CategoryController::class, 'updateCategory']);
    Route::delete('/{id}', [\App\Http\Controllers\CategoryController::class, 'deleteCategory']);
});

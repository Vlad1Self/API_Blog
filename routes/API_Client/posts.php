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


Route::prefix('posts')->group(function () {
    Route::get('/', [\App\Http\Controllers\PostController::class, 'indexPost']);
    Route::post('/', [\App\Http\Controllers\PostController::class, 'storePost']);
    Route::put('/{id}', [\App\Http\Controllers\PostController::class, 'updatePost']);
    Route::delete('/{id}', [\App\Http\Controllers\PostController::class, 'deletePost']);
});

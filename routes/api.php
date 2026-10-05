<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');

Route::get('/profile', [AuthController::class, 'profile'])
    ->middleware('auth:sanctum');

Route::get('/admin-test', function () {
    return response()->json([
        'message' => 'Anda berhasil mengakses area admin.',
    ]);
})->middleware([
    'auth:sanctum',
    'role:admin',
]);

Route::get('/products', [ProductController::class, 'index'])
    ->middleware('log.request');

Route::post('/products', [ProductController::class, 'store'])
    ->middleware('log.request');

Route::put('/products/{product}', [ProductController::class, 'update']);

Route::delete('/products/{product}', [ProductController::class, 'destroy']);
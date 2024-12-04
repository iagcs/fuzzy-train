<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::get('/me', [\App\Http\Controllers\LoginController::class, 'me']);



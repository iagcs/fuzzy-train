<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::prefix('user')->controller(UserController::class)->group(function(){
    Route::post('', 'store')->name('user.store');
});

Route::prefix('preference')->controller(\Modules\User\Http\Controllers\NewsPreferenceController::class)->group(function(){
    Route::post('', 'store');
    Route::get('', 'show');
});

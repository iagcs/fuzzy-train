<?php

use Illuminate\Support\Facades\Route;
use Modules\Article\Http\Controllers\ArticleController;

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

/*Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('article', ArticleController::class)->names('article');
});*/

Route::prefix('article')->controller(ArticleController::class)->group(function(){
    //Route::get('/{article}', 'show');
    Route::get('/', 'index');
    Route::get('/preferred', 'articles');
    Route::get('/{article}', 'show');
});

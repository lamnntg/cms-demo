<?php

use App\Http\Controllers\Api\LandingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/landing', [LandingController::class, 'index']);
Route::post('/order', [OrderController::class, 'store']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{article_id}', [NewsController::class, 'articleDetail']);


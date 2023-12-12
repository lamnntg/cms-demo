<?php


use App\Http\Controllers\Api\HouseArticleController;
use App\Http\Controllers\Api\ServiceArticleController;

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\LandingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductFavoriteController;
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
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{article_id}', [NewsController::class, 'articleDetail']);

Route::prefix('/categories')->group(function () {
    Route::get('/', [ProductController::class, 'getCategories']);
});

// authenticate API by Firebase
Route::middleware(['auth.firebase'])->group(function () {
    Route::prefix('/house-articles')->group(function () {
        Route::post('/store', [HouseArticleController::class, 'store'])->name('house-article.store');
        Route::delete('/hard-delete/{id}', [HouseArticleController::class, 'hardDelete'])->where('id', '[0-9]+')->name('house-article.hard-delete');
        Route::delete('/soft-delete/{id}', [HouseArticleController::class, 'softDelete'])->where('id', '[0-9]+')->name('house-article.soft-delete');
    });

    Route::prefix('/service-articles')->group(function () {
        Route::post('/store', [ServiceArticleController::class, 'store'])->name('service-article.store');
        Route::delete('/hard-delete/{id}', [ServiceArticleController::class, 'hardDelete'])->where('id', '[0-9]+')->name('service-article.hard-delete');
        Route::delete('/soft-delete/{id}', [ServiceArticleController::class, 'softDelete'])->where('id', '[0-9]+')->name('service-article.soft-delete');
    });
});

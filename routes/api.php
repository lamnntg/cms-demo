<?php


use App\Http\Controllers\Api\ArticleController;

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
    Route::prefix('/article')->group(function () {
        Route::post('house/store', [ArticleController::class, 'storeHouseArtical'])->name('house-article.store');
        Route::post('service/store', [ArticleController::class, 'storeServiceArtical'])->name('service-article.store');
        Route::delete('house/hard-delete/{id}', [ArticleController::class, 'hardDeleteHA'])->where('id', '[0-9]+')->name('article.hard-delete-house');
        Route::delete('house/soft-delete/{id}', [ArticleController::class, 'softDeleteHA'])->where('id', '[0-9]+')->name('article.soft-delete-house');
        Route::delete('service/hard-delete/{id}', [ArticleController::class, 'hardDeleteSA'])->where('id', '[0-9]+')->name('article.hard-delete-service');
        Route::delete('service/soft-delete/{id}', [ArticleController::class, 'softDeleteSA'])->where('id', '[0-9]+')->name('article.soft-delete-service');
    });

    Route::prefix('/news')->group(function () {
        Route::post('/store', [NewsController::class, 'store'])->name('news.store');
        Route::delete('/hard-delete/{id}', [NewsController::class, 'hardDelete'])->where('id', '[0-9]+')->name('news.hard-delete');
        Route::delete('/soft-delete/{id}', [NewsController::class, 'softDelete'])->where('id', '[0-9]+')->name('news.soft-delete');
    });
});

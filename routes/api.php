<?php


use App\Http\Controllers\Api\ArticleController;

use App\Http\Controllers\Api\LandingController;
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

Route::get('/health', function (Request $request) {
    return 'Health Check API';
});

Route::prefix('article')->group(function () {
    Route::get('/house', [ArticleController::class, 'getHouseArticles']);
    Route::get('/house/{id}', [ArticleController::class, 'getHouseArticleDetail']);

    Route::get('/service', [ArticleController::class, 'getServiceArticles']);
    Route::get('/service/{id}', [ArticleController::class, 'getServiceArticleDetail']);
});

// authenticate API by Firebase
Route::middleware(['auth.firebase'])->group(function () {
    Route::prefix('/article')->group(function () {
        Route::post('house/store', [ArticleController::class, 'storeHouseArticle'])->name('house-article.store');
        Route::post('service/store', [ArticleController::class, 'storeServiceArticle'])->name('service-article.store');

        Route::delete('house/delete/{id}', [ArticleController::class, 'deleteHouseArticle'])->where('id', '[0-9]+')->name('article.soft-delete-house');
        Route::delete('service/delete/{id}', [ArticleController::class, 'deleteServiceArticle'])->where('id', '[0-9]+')->name('article.hard-delete-service');
    });

    Route::prefix('/news')->group(function () {
        Route::post('/store', [NewsController::class, 'store'])->name('news.store');
        Route::delete('/delete/{id}', [NewsController::class, 'delete'])->where('id', '[0-9]+')->name('news.hard-delete');
    });
});

<?php


use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ManageController;
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

    Route::get('/market', [ArticleController::class, 'getMarketArticles']);
    Route::get('/market/{id}', [ArticleController::class, 'getMarketArticleDetail']);
});

Route::get('/news', [NewsController::class, 'getNews']);
Route::get('/news/{id}', [NewsController::class, 'getNewsDetail']);

// authenticate API by Firebase
Route::middleware(['auth.firebase'])->group(function () {
    Route::prefix('/article')->group(function () {
        Route::post('house/store', [ArticleController::class, 'storeHouseArticle'])->name('house-article.store');
        Route::post('service/store', [ArticleController::class, 'storeServiceArticle'])->name('service-article.store');
        Route::post('market/store', [ArticleController::class, 'storeMarketArticle'])->name('market-article.store');

        Route::patch('house/update/{id}', [ArticleController::class, 'updateHouseArticle'])->where('id', '[0-9]+')->name('house-article.update');
        Route::patch('service/update/{id}', [ArticleController::class, 'updateServiceArticle'])->where('id', '[0-9]+')->name('service-article.update');
        Route::patch('market/update/{id}', [ArticleController::class, 'updateMarketArticle'])->where('id', '[0-9]+')->name('market-article.update');

        Route::delete('house/delete/{id}', [ArticleController::class, 'deleteHouseArticle'])->where('id', '[0-9]+')->name('article.soft-delete-house');
        Route::delete('service/delete/{id}', [ArticleController::class, 'deleteServiceArticle'])->where('id', '[0-9]+')->name('article.hard-delete-service');
        Route::delete('market/delete/{id}', [ArticleController::class, 'deleteMarketArticle'])->where('id', '[0-9]+')->name('article.soft-delete-market');
    });

    Route::prefix('/news')->group(function () {
        Route::post('/store', [NewsController::class, 'store'])->name('news.store');
        Route::delete('/delete/{id}', [NewsController::class, 'delete'])->where('id', '[0-9]+')->name('news.hard-delete');
        Route::patch('/update/{id}', [NewsController::class, 'updateNews'])->where('id', '[0-9]+')->name('news.update');
    });

    Route::prefix('/manage')->group(function () {
        Route::post('/approve', [ManageController::class, 'approve'])->name('manage.approve');
    });
});

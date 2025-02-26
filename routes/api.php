<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\LandingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductFavoriteController;
use App\Http\Controllers\Api\TailoringController;
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
Route::get('/', function (Request $request) {
    return response()->json('Health Check');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/landing', [LandingController::class, 'index']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{article_id}', [NewsController::class, 'articleDetail']);


Route::prefix('/product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [ProductController::class, 'getCategories']);
});

Route::prefix('/tailoring')->group(function () {
    Route::get('/store', [TailoringController::class, 'storeTailoring']);
});

// authenticate API by Firebase
Route::middleware(['auth.firebase'])->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);

    Route::get('/order', [OrderController::class, 'index']);
    Route::post('/order', [OrderController::class, 'store']);
    Route::get('/product-favorites', [ProductFavoriteController::class, 'index']);
    Route::post('/product-favorites/add', [ProductFavoriteController::class, 'store']);
    Route::delete('/product-favorites/delete', [ProductFavoriteController::class, 'delete']);
});

// Api for admin
Route::middleware('auth.token')->group(function () {
    Route::post('/image-upload', [AdminHomeController::class, 'uploadImage'])->name('image.upload');
    Route::post('/image-upload-local', [AdminHomeController::class, 'uploadImageLocal'])->name('image.uploadLocal');

    Route::post('/product/store', [AdminProductController::class, 'store'])->name('product.store');
    Route::post('/product/update/{id}', [AdminProductController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{id}', [AdminProductController::class, 'delete'])->name('product.delete');
});

<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\LandingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('/landing')->group(function () {
        Route::get('/', [LandingController::class, 'index'])->name('landing');
        Route::post('/change-banner', [LandingController::class, 'changeBanner'])->name('landing.update-banner');
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile',  [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('/event')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('event');
        Route::post('/store', [EventController::class, 'store'])->name('event.store');
    });

    Route::prefix('/product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    });

    Route::prefix('/article')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('article');
        Route::post('/store', [ArticleController::class, 'store'])->name('article.store');
    });

    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
    });

    Route::prefix('/order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order');
    });

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});

require __DIR__ . '/auth.php';

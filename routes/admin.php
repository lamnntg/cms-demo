<?php

use App\Http\Controllers\Admin\LandingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/landing')->group(function () {
    Route::get('/', [LandingController::class, 'index'])->name('landing');
    Route::post('/change-banner', [LandingController::class, 'changeBanner'])->name('landing.update-banner');
});


Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile',  [ProfileController::class, 'update'])->name('profile.update');


Route::get('/about', function () {
    return view('about');
})->name('about');

require __DIR__ . '/auth.php';

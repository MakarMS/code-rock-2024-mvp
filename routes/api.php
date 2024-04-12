<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\Users\Auth\BuyerAuthController;
use App\Http\Controllers\Users\Auth\ManufacturerAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('user')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::prefix('buyer')->group(function () {
            Route::post('/register', [BuyerAuthController::class, 'register']);
            Route::post('/login', [BuyerAuthController::class, 'login']);
            Route::post('/refresh', [BuyerAuthController::class, 'refresh']);
            Route::post('/valid', [BuyerAuthController::class, 'valid']);
            Route::post('/logout', [BuyerAuthController::class, 'logout']);
        });

        Route::prefix('manufacturer')->group(function () {
            Route::post('/register', [ManufacturerAuthController::class, 'register']);
            Route::post('/login', [ManufacturerAuthController::class, 'login']);
            Route::post('/refresh', [ManufacturerAuthController::class, 'refresh']);
            Route::post('/valid', [ManufacturerAuthController::class, 'valid']);
            Route::post('/logout', [ManufacturerAuthController::class, 'logout']);
        });
    });
});

Route::prefix('manufacturer')->group(function () {
    Route::prefix('route')->group(function () {
        Route::post('/', [RouteController::class, 'store']);
        Route::get('/', [RouteController::class, 'index']);
        Route::get('/{id}', [RouteController::class, 'show']);
        Route::post('/{id}', [RouteController::class, 'update']);
        Route::delete('/{id}', [RouteController::class, 'destroy']);
    });
})->middleware('auth:manufacturer');

Route::get('/city', [CityController::class, 'index'])->middleware('auth:manufacturer');

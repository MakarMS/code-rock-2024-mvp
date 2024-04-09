<?php

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
        });

        Route::prefix('manufacturer')->group(function () {
            Route::post('/register', [ManufacturerAuthController::class, 'register']);
            Route::post('/login', [ManufacturerAuthController::class, 'login']);
            Route::post('/refresh', [ManufacturerAuthController::class, 'refresh']);
            Route::post('/valid', [ManufacturerAuthController::class, 'valid']);
        });

    });
});

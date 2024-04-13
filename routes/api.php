<?php

use App\Http\Controllers\Buyer\OrderController;
use App\Http\Controllers\Buyer\PlanController;
use App\Http\Controllers\Manufacturer\CityController;
use App\Http\Controllers\Manufacturer\PointController;
use App\Http\Controllers\Manufacturer\ProductController;
use App\Http\Controllers\Manufacturer\RouteController;
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
        Route::prefix('city')->group(function () {
            Route::get('/', [CityController::class, 'routesCities']);
        });

        Route::post('/', [RouteController::class, 'store']);
        Route::get('/', [RouteController::class, 'index']);
        Route::get('/{id}', [RouteController::class, 'show']);
        Route::post('/{id}', [RouteController::class, 'update']);
        Route::delete('/{id}', [RouteController::class, 'destroy']);

    });

    Route::prefix('point')->group(function () {
        Route::post('/', [PointController::class, 'store']);
        Route::get('/', [PointController::class, 'index']);
        Route::delete('/{id}', [PointController::class, 'destroy']);
    });

    Route::prefix('city')->group(function () {
        Route::get('/', [CityController::class, 'index']);
    });

    Route::prefix('product')->group(function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::post('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);

    });
})->middleware('auth:manufacturer');


Route::prefix('buyer')->group(function () {
    Route::prefix('product')->group(function () {
        Route::get('/', [\App\Http\Controllers\Buyer\ProductController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Buyer\ProductController::class, 'show']);
    });

    Route::prefix('order')->group(function () {
        Route::post('/', [OrderController::class, 'store']);
    });

    Route::prefix('delivery')->group(function () {
        Route::get('plan/{id}', [PlanController::class, 'show']);
    });
})->middleware('auth:buyer');

<?php

use App\Http\Controllers\Api\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\MealController;

Route::prefix('auth')->group(function () {
    Route::post('register',        [AuthController::class, 'register']);
    Route::post('verify-otp',      [AuthController::class, 'verifyOtp']);
    Route::post('login',           [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password',  [AuthController::class, 'resetPassword']);
});


Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me',      [AuthController::class, 'me']);
    });

    // Meals
    Route::prefix('meals')->group(function () {
        Route::get('categories', [MealController::class, 'categories']);
        Route::get('/',          [MealController::class, 'index']);
        Route::get('{meal}',     [MealController::class, 'show']);
    });

    // Cart
    Route::prefix('cart')->group(function () {
        Route::get('/',              [CartController::class, 'index']);
        Route::post('/',             [CartController::class, 'add']);
        Route::patch('{meal_id}',    [CartController::class, 'update']);
        Route::delete('{meal_id}',   [CartController::class, 'remove']);
        Route::delete('/',           [CartController::class, 'clear']);
    });

    // Favorites
    Route::prefix('favorites')->group(function () {
        Route::get('/',           [FavoriteController::class, 'index']);
        Route::post('/',          [FavoriteController::class, 'add']);
        Route::delete('{meal_id}',[FavoriteController::class, 'remove']);
});
});

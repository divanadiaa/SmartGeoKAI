<?php

use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\RegencyController;
use Illuminate\Support\Facades\Route;

Route::prefix('petugas')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/provinces', [ProvinceController::class, 'index']);
    Route::get('/regencies', [RegencyController::class, 'index']);
    Route::get('/districts', [DistrictController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/profile', [ProfileController::class, 'show']);
        Route::post('/change-password', [ProfileController::class, 'changePassword']);
        Route::get('/profile/histories', [ProfileController::class, 'histories']);

        Route::get('/assets', [AssetController::class, 'index']);
        Route::get('/assets/map', [AssetController::class, 'map']);
        Route::get('/assets/{asset}', [AssetController::class, 'show']);
        Route::post('/assets', [AssetController::class, 'store']);
        Route::post('/assets/{asset}', [AssetController::class, 'update']);
        Route::delete('/assets/{asset}', [AssetController::class, 'destroy']);

        Route::delete('/assets/{asset}/images/{image}', [AssetController::class, 'deleteImage']);

        Route::delete('/assets/{asset}/documents/{document}', [AssetController::class, 'deleteDocument']);
    });
});
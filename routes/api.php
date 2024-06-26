<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmissionRecordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\ResolveSourceModelMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');;
    Route::get('me', [AuthController::class, 'me'])->name('me')->middleware('auth:sanctum');;
});

Route::apiResource('vehicles', VehicleController::class)->middleware('auth:sanctum');
Route::prefix('vehicles')->name('vehicles.')->group(function () {
    Route::apiResource('{sourceId}/emission-records', EmissionRecordController::class)->except(['update'])->middleware(['auth:sanctum', ResolveSourceModelMiddleware::class]);
})->middleware('auth:sanctum');

Route::apiResource('homes', HomeController::class)->middleware('auth:sanctum');
Route::prefix('homes')->name('homes.')->group(function () {
    Route::apiResource('{sourceId}/emission-records', EmissionRecordController::class)->except(['update'])->middleware(['auth:sanctum', ResolveSourceModelMiddleware::class]);
})->middleware('auth:sanctum');

Route::get('emission-records', [EmissionRecordController::class, 'indexAll'])->name('emission-records.indexAll')->middleware('auth:sanctum');

Route::get('statistics', [StatisticController::class, 'index'])->name('statistics.index')->middleware('auth:sanctum');

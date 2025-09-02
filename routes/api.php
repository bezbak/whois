<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\DomainCheckController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/domains', [DomainController::class, 'store']);  // сохранить домен в БД
    Route::get('/domains', [DomainController::class, 'index']);  // список доменов
    Route::post('/domains/check', [DomainCheckController::class, 'check']); // проверить 1 домен
    Route::post('/logout', [AuthController::class, 'logout']);
});
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('/logout', [AuthController::class, 'logout']);
    });
});


Route::prefix('page')->group(function () {
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('/create', [PageController::class, 'create']);
    });
});

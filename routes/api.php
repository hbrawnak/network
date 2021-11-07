<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
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
        Route::post('/{pageId}/attach-post', [PostController::class, 'page_post']);
    });
});

Route::prefix('follow')->group(function () {
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('/person/{personId}', [FollowerController::class, 'follow_person']);
        Route::get('/page/{pageId}', [FollowerController::class, 'follow_page']);
    });
});

Route::prefix('person')->group(function () {
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('/attach-post', [PostController::class, 'user_post']);
        //Route::get('/feed', []);
    });
});

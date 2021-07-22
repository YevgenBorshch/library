<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Author\AuthorListController;
use App\Http\Controllers\Api\Author\AuthorStoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('/auth')->group(function () {
    Route::post('/login', [LoginController::class, '__invoke']);
    Route::post('/register', [RegistrationController::class, '__invoke']);
});

Route::middleware('auth:api')->group(function () {

    // Author
    Route::prefix('/author')->group(function () {
        Route::get('/list', [AuthorListController::class, '__invoke']);
        Route::post('/store', [AuthorStoreController::class, '__invoke']);
    });

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

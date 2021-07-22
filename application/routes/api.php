<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Author\AuthorListController;
use App\Http\Controllers\Api\Author\AuthorStoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('/auth')->group(function () {
    Route::post('/login', [LoginController::class, '__invoke'])->name('auth.login');
    Route::post('/register', [RegistrationController::class, '__invoke'])->name('auth.register');
});

Route::middleware('auth:api')->group(function () {

    // Author
    Route::prefix('/author')->group(function () {
        Route::post('/list', [AuthorListController::class, '__invoke'])->name('author.list');
        Route::post('/store', [AuthorStoreController::class, '__invoke'])->name('author.store');
    });

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

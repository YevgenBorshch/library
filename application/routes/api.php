<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Author\AuthorGetController;
use App\Http\Controllers\Api\Author\AuthorListController;
use App\Http\Controllers\Api\Author\AuthorRemoveController;
use App\Http\Controllers\Api\Author\AuthorStoreController;
use App\Http\Controllers\Api\Author\AuthorUpdateController;
use App\Http\Controllers\Api\Category\CategoryGetController;
use App\Http\Controllers\Api\Category\CategoryListController;
use App\Http\Controllers\Api\Category\CategoryStoreController;
use App\Http\Controllers\Api\Category\CategoryUpdateController;
use App\Http\Controllers\Api\Series\SeriesGetController;
use App\Http\Controllers\Api\Series\SeriesListController;
use App\Http\Controllers\Api\Series\SeriesStoreController;
use App\Http\Controllers\Api\Series\SeriesUpdateController;
use App\Http\Controllers\Api\Tag\TagGetController;
use App\Http\Controllers\Api\Tag\TagListController;
use App\Http\Controllers\Api\Tag\TagStoreController;
use App\Http\Controllers\Api\Tag\TagUpdateController;
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
        Route::get('/list', [AuthorListController::class, '__invoke'])->name('author.list');
        Route::post('/store', [AuthorStoreController::class, '__invoke'])->name('author.store');
        Route::get('/get/{author}', [AuthorGetController::class, '__invoke'])->name('author.get');
        Route::post('/update', [AuthorUpdateController::class, '__invoke'])->name('author.update');
        Route::post('/remove', [AuthorRemoveController::class, '__invoke'])->name('author.remove');
    });

    // Category
    Route::prefix('/category')->group(function () {
        Route::get('/list', [CategoryListController::class, '__invoke'])->name('category.list');
        Route::post('/store', [CategoryStoreController::class, '__invoke'])->name('category.store');
        Route::get('/get/{category}', [CategoryGetController::class, '__invoke'])->name('category.get');
        Route::post('/update', [CategoryUpdateController::class, '__invoke'])->name('category.update');
    });

    // Tag
    Route::prefix('/tag')->group(function () {
        Route::get('/list', [TagListController::class, '__invoke'])->name('tag.list');
        Route::post('/store', [TagStoreController::class, '__invoke'])->name('tag.store');
        Route::get('/get/{tag}', [TagGetController::class, '__invoke'])->name('tag.get');
        Route::post('/update', [TagUpdateController::class, '__invoke'])->name('tag.update');
    });

    // Series
    Route::prefix('/series')->group(function () {
        Route::get('/list', [SeriesListController::class, '__invoke'])->name('series.list');
        Route::post('/store', [SeriesStoreController::class, '__invoke'])->name('series.store');
        Route::get('/get/{series}', [SeriesGetController::class, '__invoke'])->name('series.get');
        Route::post('/update', [SeriesUpdateController::class, '__invoke'])->name('series.update');
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

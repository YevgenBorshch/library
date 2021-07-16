<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Author\AuthorStoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('/auth')->group(function () {
    Route::post('/login', [LoginController::class, '__invoke']);
    Route::post('/register', [RegistrationController::class, '__invoke']);
});

Route::prefix('/author')->group(function () {
    Route::post('/store', [AuthorStoreController::class, '__invoke']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

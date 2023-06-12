<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\ArticleController;

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

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('news')->group(function () {
        Route::get('/categories', [SourceController::class, 'getCategories']);
        Route::get('/sources', [SourceController::class, 'getSources']);
        Route::get('/authors', [ArticleController::class, 'getAuthors']);

        Route::get('/feeds', [ArticleController::class, 'feeds']);

        Route::get('/request-feeds', [ArticleController::class, 'requestFeeds']);



    });

    Route::prefix('users')->group(function () {
        Route::post('/save-preferences', [UserController::class, 'savePreferences']);
        Route::get('/get-preferences', [UserController::class, 'getPreferences']);


    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

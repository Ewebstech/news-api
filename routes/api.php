<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
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

    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

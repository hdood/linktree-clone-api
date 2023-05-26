<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\LinkImageController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\UserImageController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('users', [UserController::class, 'index']);
    Route::patch('users/{user}', [UserController::class, 'update']);

    Route::post('user-image', [UserImageController::class, 'store']);

    Route::get('links', [LinkController::class, 'index']);
    Route::post('links', [LinkController::class, 'store']);
    Route::patch('links/{link}', [LinkController::class, 'update']);
    Route::delete('links/{link}', [LinkController::class, 'destroy']);

    Route::post('link-image', [LinkImageController::class, 'store']);

    Route::get('themes', [ThemeController::class, 'index']);
    Route::patch('themes', [ThemeController::class, 'update']);
});


Route::get("users/{name}",  [UserController::class, "show"]);

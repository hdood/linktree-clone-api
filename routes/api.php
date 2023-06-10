<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\LinkImageController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\UserImageController;
use App\Http\Controllers\Api\UserPortfolioController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserCoverImageController;

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
    Route::patch('users/contact/{user}', [UserController::class, 'updateContact']);
    Route::get('users/search/{term}', [UserController::class, "searchByName"]);

    Route::post('user-image', [UserImageController::class, 'store']);
    Route::post('user-cover-image', [UserCoverImageController::class, 'store']);

    Route::get('links', [LinkController::class, 'index']);
    Route::post('links', [LinkController::class, 'store']);
    Route::patch('links/{link}', [LinkController::class, 'update']);
    Route::delete('links/{link}', [LinkController::class, 'destroy']);

    Route::post('link-image', [LinkImageController::class, 'store']);


    Route::post("user-portfolio", [UserPortfolioController::class, "store"]);
    Route::post("download-portfolio", [UserPortfolioController::class, "download"]);

    Route::get('themes', [ThemeController::class, 'index']);
    Route::patch('themes', [ThemeController::class, 'update']);

    // media routes
    Route::post("media/embedded", [MediaController::class, "storeEmbeddedMedia"]);
    Route::post("media/file", [MediaController::class, "storeFileMedia"]);
    Route::get("media/{user}", [MediaController::class, "index"]);
});


Route::get("users/{name}",  [UserController::class, "show"]);
Route::get('users/check-name/{name}', [UserController::class, "checkName"]);

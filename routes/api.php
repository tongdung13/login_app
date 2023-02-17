<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;

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


Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);


Route::middleware('guest')->group(function () {
    Route::prefix('blogs')->group(function () {
        Route::get('', [BlogController::class, 'index']);
        Route::get('show/{id}', [BlogController::class, 'show']);
    });
});

Route::post('test', [BlogController::class, 'pdf']);

<?php

use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\UserController;
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


// posts routes
Route::group(['middleware' => ['api'], "prefix" => "/auth"], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login'])->name("login");
});

Route::middleware(["api", "auth:sanctum"])->post('/auth/logout', [UserController::class, 'logout']);

Route::group(['middleware' => ['api', 'auth:sanctum'], "prefix" => "/notification"], function () {
    Route::post('/send', [NotificationsController::class, 'send']);
    Route::get('/report', [NotificationsController::class, 'report']);
});

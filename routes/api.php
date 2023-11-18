<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\UserProfileController;
use App\Http\Controllers\Api\V1\Auth\UserAuthController;
use App\Http\Controllers\Api\V1\Auth\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('auth/google', [GoogleAuthController::class, 'redirect']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::post('auth/signup', [UserAuthController::class, 'signup']);
Route::post('auth/login', [UserAuthController::class, 'login']);


Route::get('users/event', [EventController::class, 'index']);


Route::middleware('auth:sanctum')->group(function() {
    Route::post('auth/logout', [UserAuthController::class, 'logout']);
    
    Route::apiResource('users/profile', UserProfileController::class);

    Route::apiResource('users/event', EventController::class)->only('store', 'show', 'update');
});


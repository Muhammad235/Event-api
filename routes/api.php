<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\PublicEventController;
use App\Http\Controllers\Api\V1\UserProfileController;
use App\Http\Controllers\Api\V1\Auth\UserAuthController;
use App\Http\Controllers\Api\V1\Auth\GoogleAuthController;
use App\Http\Controllers\Api\V1\EventRegistrationController;

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


Route::get('login/google', [GoogleAuthController::class, 'redirect']);
Route::get('login/google/callback', [GoogleAuthController::class, 'callback']);

Route::post('auth/signup', [UserAuthController::class, 'signup']);
Route::post('auth/login', [UserAuthController::class, 'login']);


Route::get('events', [PublicEventController::class, 'index']);
Route::get('events/search/{search}', [PublicEventController::class, 'search']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('auth/logout', [UserAuthController::class, 'logout']);
    
    Route::apiResource('users/profile', UserProfileController::class);

    Route::apiResource('users/event', EventController::class);

    Route::get('users/search/{search}', [EventController::class, 'search']);

    Route::post('event/register/{eventId}', [EventRegistrationController::class, 'store']);

});
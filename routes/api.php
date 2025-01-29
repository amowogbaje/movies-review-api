<?php

use App\Http\Controllers\Api\v1\AdminController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\v1\ReviewController;
use App\Http\Controllers\Api\v1\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])
        ->middleware('approved');
    
    // Admin routes
    Route::prefix('admin')->middleware('can:manage-content')->group(function () {
        Route::post('/users/{user}/approve', [AdminController::class, 'approveUser']);
        Route::apiResource('movies', MovieController::class)->except(['index', 'show']);
    });
});

Route::apiResource('movies', MovieController::class)->only(['index', 'show']);

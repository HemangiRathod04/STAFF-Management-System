<?php

use App\Http\Controllers\StaffController;
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

Route::post('/staff/register', [StaffController::class, 'register']);
Route::post('/staff/login', [StaffController::class, 'login']);

Route::middleware('auth:api')->group(function () {
        Route::get('/staff/profile', [StaffController::class, 'getProfile']);
        Route::post('/staff/profile', [StaffController::class, 'updateProfile']);
        Route::post('/staff/clock-in', [StaffController::class, 'clockIn']);
        Route::post('/staff/clock-out', [StaffController::class, 'clockOut']);
        Route::post('/staff/logout', [StaffController::class, 'logout']);

});
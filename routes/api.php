<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusController;
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

Route::controller(AuthController::class)->group(function() {
    Route::post('/v1/auth/login', 'login');
});

Route::middleware('auth:sanctum')->group(function(){

    Route::controller(AuthController::class)->group(function(){
        Route::get('/v1/auth/me', 'me');
        Route::get('/v1/auth/logout', 'logout');
    });

    Route::controller(BusController::class)->group(function(){
        Route::get('/v1/buses', 'index');
    });


});

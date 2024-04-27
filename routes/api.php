<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\OrderController;
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

// Route::middleware('auth:sanctum')->group(function(){

    Route::controller(AuthController::class)->group(function(){
        Route::get('/v1/auth/me', 'me');
        Route::get('/v1/auth/logout', 'logout');
    });

    Route::controller(BusController::class)->group(function(){
        Route::get('/v1/buses', 'index');
        Route::post('/v1/buses', 'store');
        Route::put('/v1/buses/{id}', 'update');
        Route::delete('/v1/buses/{id}', 'destroy');
    });

    Route::controller(DriverController::class)->group(function(){
        Route::get('/v1/drivers', 'index');
        Route::post('/v1/drivers', 'store');
        Route::put('/v1/drivers/{id}', 'update');
        Route::delete('/v1/drivers/{id}', 'destroy');
    });

    Route::controller(OrderController::class)->group(function(){
        Route::get('/v1/orders', 'index');
        Route::post('/v1/orders', 'store');
        Route::delete('/v1/orders/{id}', 'delete');
    });
// });

<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\ZoneController;
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

Route::group([
    'prefix'     => 'v1/auth',
    'as'         => 'auth.',
    'controller' => AuthController::class,
], function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

Route::group([
    'prefix'     => 'v1/profile',
    'as'         => 'profile.',
    'controller' => ProfileController::class,
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('', 'show')->name('show');
    Route::patch('', 'update')->name('update');
    Route::patch('password', 'updatePassword')->name('updatePassword');
});

Route::apiResource('v1/vehicles', VehicleController::class)->middleware('auth:sanctum');

Route::group([
    'prefix'     => 'v1/zones',
    'as'         => 'zone.',
    'controller' => ZoneController::class,
], function () {
    Route::get('', 'index')->name('index');
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'manufacturers'], function () {
    Route::get('/', [Api\ManufacturersController::class, 'index']);
    Route::post('/save', [Api\ManufacturersController::class, 'save']);
    Route::get('/{id}', [Api\ManufacturersController::class, 'show']);
    Route::put('/update/{id}', [Api\ManufacturersController::class, 'update']);
    Route::delete('{manufacturer}', [Api\ManufacturersController::class, 'destroy']);
});

Route::group(['prefix' => 'cars'], function () {
    Route::get('/', [Api\CarsController::class, 'index']);
    Route::post('/save', [Api\CarsController::class, 'save']);
    Route::get('/{id}', [Api\CarsController::class, 'show']);
    Route::put('/update/{id}', [Api\CarsController::class, 'update']);
    Route::delete('{cars}', [Api\CarsController::class, 'destroy']);
});


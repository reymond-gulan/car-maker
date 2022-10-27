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
    Route::delete('{manufacturer}', [Api\ManufacturersController::class, 'destroy']);
});


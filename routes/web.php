<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth:web'], function () {
    
    Route::group(['prefix' => 'manufacturers'], function () {
        Route::get('/', [Admin\ManufacturersController::class, 'index'])->name('manufacturers');
    });

    Route::group(['prefix' => 'cars'], function () {
        Route::get('/', [Admin\CarsController::class, 'index'])->name('cars');
    });
});

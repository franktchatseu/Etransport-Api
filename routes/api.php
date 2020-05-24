<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::pattern('id', '[0-9]+');

Route::group(['prefix' => 'auth'], function () {

    Route::post('token', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'AuthController@user');
        Route::delete('token', 'AuthController@logout');
        Route::get('permissions', 'AuthController@permissions');
        Route::get('roles', 'AuthController@roles');
        Route::get('teams', 'AuthController@teams');

   });

});

// Messagerie module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'messagerie'], function () {

});

// Notification module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'notification'], function () {

});

// Person module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'person'], function () {

});

// Place module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'place'], function () {

});

// Setting module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'setting'], function () {

});

// statistic module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'statistic'], function () {

    Route::group(['prefix' => 'finance'], function () {
        Route::get('/', 'Statistic\FinanceController@getFinance');
    });

});



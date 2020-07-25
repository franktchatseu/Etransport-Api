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
    Route::post('persons/users', 'Person\UserController@create');

    //Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'AuthController@user');
        Route::delete('token', 'AuthController@logout');
    //});
});


// Module1 module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'module1'], function () {

    Route::group(['prefix' => ''], function () {
    });

});

// Module2 module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'module2'], function () {

    Route::group(['prefix' => ''], function () {
    });

});

// Module3 module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'module3'], function () {

    Route::group(['prefix' => ''], function () {
    });

});

// Module4 module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'module4'], function () {

    Route::group(['prefix' => 'transportElement'], function () {
        Route::post('/', 'Module4\TransportElementController@store');
        Route::post('/{id}', 'Module4\TransportElementController@update');
        Route::delete('/{id}', 'Module4\TransportElementController@destroy');
        Route::get('/{id}', 'Module4\TransportElementController@find');
        Route::get('/', 'Module4\TransportElementController@index');

    });

    Route::group(['prefix' => 'actorType'], function () {
        Route::post('/', 'Module4\ActorTypeController@store');
        Route::put('/{id}', 'Module4\ActorTypeController@update');
        Route::delete('/{id}', 'Module4\ActorTypeController@destroy');
        Route::get('/{id}', 'Module4\ActorTypeController@find');
        Route::get('/', 'Module4\ActorTypeController@index');

    });

});

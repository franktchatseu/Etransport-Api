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

    Route::group(['prefix' => 'types'], function () {
        Route::get('/', 'Module3\typeController@index');
        Route::get('/{id}', 'Module3\typeController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\typeController@update');
        Route::post('/', 'Module3\typeController@store');
        Route::delete('/{id}', 'Module3\typeController@destroy');
    });

    Route::group(['prefix' => 'carosseries'], function () {
        Route::get('/', 'Module3\carosserieController@index');
        Route::get('/{id}', 'Module3\carosserieController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\carosserieController@update');
        Route::post('/', 'Module3\carosserieController@store');
        Route::delete('/{id}', 'Module3\carosserieController@destroy');
    });

    Route::group(['prefix' => 'marks'], function () {
        Route::get('/', 'Module3\markController@index');
        Route::get('/{id}', 'Module3\markController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\markController@update');
        Route::post('/', 'Module3\markController@store');
        Route::delete('/{id}', 'Module3\markController@destroy');
    });

    Route::group(['prefix' => 'modeles'], function () {
        Route::get('/', 'Module3\modelController@index');
        Route::get('/{id}', 'Module3\modelController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\modelController@update');
        Route::post('/', 'Module3\modelController@store');
        Route::delete('/{id}', 'Module3\modelController@destroy');
    });


    Route::group(['prefix' => 'caractere_tech_ones'], function () {
        Route::get('/', 'Module3\caractertechoneController@index');
        Route::get('/{id}', 'Module3\caractertechoneController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\caractertechoneController@update');
        Route::post('/', 'Module3\caractertechoneController@store');
        Route::delete('/{id}', 'Module3\caractertechoneController@destroy');
    });


    Route::group(['prefix' => 'gear_pictures'], function () {
        Route::get('/', 'Module3\gearpictureController@index');
        Route::get('/{id}', 'Module3\gearpictureController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\gearpictureController@update');
        Route::post('/', 'Module3\gearpictureController@store');
        Route::delete('/{id}', 'Module3\gearpictureController@destroy');
    });


    Route::group(['prefix' => 'stepper_trees'], function () {
        Route::get('/', 'Module3\steppertreeController@index');
        Route::get('/{number}', 'Module3\steppertreeController@find');
        Route::match(['post', 'put'], '/{number}', 'Module3\steppertreeController@update');
        Route::post('/', 'Module3\steppertreeController@store');
        Route::delete('/{number}', 'Module3\steppertreeController@destroy');
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

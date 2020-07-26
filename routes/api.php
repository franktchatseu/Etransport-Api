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
        Route::get('/', 'module3\typeController@index');
        Route::get('/{id}', 'module3\typeController@find');
        Route::match(['post', 'put'], '/{id}', 'module3\typeController@update');
        Route::post('/', 'module3\typeController@create');
        Route::delete('/{id}', 'module3\typeController@destroy');
    });

    Route::group(['prefix' => 'carosseries'], function () {
        Route::get('/', 'module3\typeController@index');
        Route::get('/{id}', 'module3\typeController@find');
        Route::match(['post', 'put'], '/{id}', 'module3\typeController@update');
        Route::post('/', 'module3\typeController@create');
        Route::delete('/{id}', 'module3\typeController@destroy');
    });

    Route::group(['prefix' => 'marks'], function () {
        Route::get('/', 'module3\typeController@index');
        Route::get('/{id}', 'module3\typeController@find');
        Route::match(['post', 'put'], '/{id}', 'module3\typeController@update');
        Route::post('/', 'module3\typeController@create');
        Route::delete('/{id}', 'module3\typeController@destroy');
    });

    Route::group(['prefix' => 'modeles'], function () {
        Route::get('/', 'module3\typeController@index');
        Route::get('/{id}', 'module3\typeController@find');
        Route::match(['post', 'put'], '/{id}', 'module3\typeController@update');
        Route::post('/', 'module3\typeController@create');
        Route::delete('/{id}', 'module3\typeController@destroy');
    });

    Route::group(['prefix' => 'caractertechtwos'], function () {
        Route::get('/', 'module3\caracterTechTwoController@index');
        Route::get('/{id}', 'module3\caracterTechTwoController@find');
        Route::match(['post', 'put'], '/{id}', 'module3\caracterTechTwoController@update');
        Route::post('/', 'module3\caracterTechTwoController@store');
        Route::delete('/{id}', 'module3\caracterTechTwoController@destroy');
    });

    Route::group(['prefix' => 'carpapers'], function () {
        Route::get('/', 'module3\CarPaperController@index');
        Route::get('/{id}', 'module3\CarPaperController@find');
        Route::match(['post', 'put'], '/{id}', 'module3\CarPaperController@update');
        Route::post('/', 'module3\CarPaperController@store');
        Route::delete('/{id}', 'module3\CarPaperController@destroy');
    });

    Route::group(['prefix' => 'descriptions'], function () {
        Route::get('/', 'module3\DescriptionController@index');
        Route::get('/{id}', 'module3\DescriptionController@find');
        Route::match(['post', 'put'], '/{id}', 'module3\DescriptionController@update');
        Route::post('/', 'module3\DescriptionController@store');
        Route::delete('/{id}', 'module3\DescriptionController@destroy');
    });



});

// Module4 module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'module4'], function () {

    Route::group(['prefix' => ''], function () {
    });

});

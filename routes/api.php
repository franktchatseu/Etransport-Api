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
Route::group(['prefix' => 'messageries'], function () { });

Route::group(['prefix' => 'parish'], function () {
    Route::group(['prefix' => 'parish_patrimonies'], function () {
        Route::get('/', 'Setting\ParishPatrimonyController@index');
        Route::delete('/{id}', 'Setting\ParishPatrimonyController@destroy');
        Route::get('/{id}', 'Setting\ParishPatrimonyController@find');
        Route::get('/search', 'Setting\ParishPatrimonyController@search');
        Route::post('parishparimony', 'Setting\ParishPatrimonyController@create');
    });
});
// Notification module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'notifications'], function () { });

// Person module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'persons'], function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'Person\UserController@index');
        Route::get('/search', 'Person\UserController@search');
        Route::post('/', 'Person\UserController@create');
        Route::get('/{id}', 'Person\UserController@find');
        Route::match(['post', 'put'], '/{id}', 'Person\UserController@update');
        Route::delete('/{id}', 'Person\UserController@destroy');
    });

    Route::group(['prefix' => 'profressions'], function () {
        Route::get('/', 'Person\ProfessionsController@index');
        Route::get('/search', 'Person\ProfessionsController@search');
        Route::post('/', 'Person\ProfessionsController@store');
        Route::get('/{id}', 'Person\ProfessionsController@find');
        Route::match(['post', 'put'], '/{id}', 'Person\ProfessionsController@update');
        Route::delete('/{id}', 'Person\ProfessionsController@destroy');
    });

    Route::group(['prefix' => 'sacraments'], function () {
        Route::get('/', 'Person\SacramentController@allSacrament');
        Route::get('/search', 'Person\SacramentController@searchStatement');
        Route::get('/{id}', 'Person\SacramentController@findStatement');
        Route::delete('/{id}', 'Person\SacramentController@destroyStatement');
        Route::post('/{id}', 'Person\SacramentController@updateStatement');
        Route::post('/', 'Person\SacramentController@createStatement');
    });

    Route::group(['prefix' => 'priests'], function () {
        Route::get('/', 'Person\PriestController@index');
        Route::get('/find/{id}', 'Person\PriestController@find');
        Route::get('/search', 'Person\PriestController@search');
        Route::delete('/{id}', 'Person\PriestController@destroy');
        Route::match(['post', 'put'], '/{id}', 'Person\PriestController@update');
        Route::post('/', 'Person\PriestController@store');
    });

    Route::group(['prefix' => 'parishionals'], function () {
        Route::get('/', 'Person\ParishionalController@index');
        Route::get('/search', 'Person\ParishionalController@search');
        Route::get('/find/{id}', 'Person\ParishionalController@find');
        Route::delete('/{id}', 'Person\ParishionalController@find');
        Route::post('/', 'Person\ParishionalController@store');
        Route::match(['post', 'put'], '/{id}', 'Person\ParishionalController@update');
    });
});

// Place module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'place'], function () { });

// Setting module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'settings'], function () {

    Route::group(['prefix' => 'parishs'], function () {
        Route::get('/', 'Setting\ParishController@index');
        Route::get('/search', 'Setting\ParishController@search');
        Route::get('/{id}', 'Setting\ParishController@find');
        Route::delete('/{id}', 'Setting\ParishController@delete');
        Route::post('/', 'Setting\ParishController@store');
        Route::match(['post', 'put'], '/{id}', 'Setting\ParishController@update');
    });

    Route::group(['prefix' => 'parishs'], function () {
        Route::get('/', 'Setting\ParishPatrimonyController@index');
        Route::get('/search', 'Setting\ParishPatrimonyController@search');
        Route::get('/{id}', 'Setting\ParishPatrimonyController@find');
        Route::delete('/{id}', 'Setting\ParishPatrimonyController@delete');
        Route::post('/', 'Setting\ParishPatrimonyController@store');
        Route::match(['post', 'put'], '/{id}', 'Setting\ParishPatrimonyController@update');
    });

    Route::group(['prefix' => 'albums'], function () {
        Route::get('/', 'Setting\AlbumController@index');
        Route::get('/{id}', 'Setting\AlbumController@find');
        Route::get('/search', 'Setting\AlbumController@search');
        Route::delete('/{id}', 'Setting\AlbumController@destroy');
        Route::match(['post', 'put'], '/{id}', 'Setting\AlbumController@update');
        Route::post('/', 'Setting\AlbumController@store');
    });
});

// statistic module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'statistics'], function () {

    Route::group(['prefix' => 'finance'], function () {
        Route::get('/', 'Statistic\FinanceController@getFinance');
    });
});

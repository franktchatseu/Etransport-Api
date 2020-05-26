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
    Route::group(['prefix' => 'parishional'], function () {
        Route::get('/', 'Person\ParishionalController@index');
        Route::get('/search', 'Person\ParishionalController@search');
        Route::get('/find/{id}', 'Person\ParishionalController@find');
        Route::delete('/{id}', 'Person\ParishionalController@find');
        Route::post('/', 'Person\ParishionalController@store');
        Route::match(['post','put'],'/{id}','Person\ParishionalController@update');
    });
   
});

// Place module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'place'], function () {

});

// Setting module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'setting'], function () {
   Route::group(['prefix' => 'parish'], function () {
    Route::get('/', 'Setting\ParishController@index');
    Route::get('/search', 'Setting\ParishController@search');
    Route::get('/find/{id}', 'Setting\ParishController@find');
    Route::delete('/{id}', 'Setting\ParishController@find');
    Route::post('/', 'Setting\ParishController@store');
    Route::match(['post','put'],'/{id}','Setting\ParishController@update');
    });

    
});

// statistic module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'statistic'], function () {

    Route::group(['prefix' => 'finance'], function () {
        Route::get('/', 'Statistic\FinanceController@getFinance');
    });

});



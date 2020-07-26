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

    Route::group(['prefix' => ' '], function () {
        Route::get('/', 'Module1\Info_Entreprise_OneController@index');
        Route::get('/{id}', 'Module1\Info_Entreprise_OneController@find');
        Route::match(['post', 'put'], '/{id}', 'Module1\Info_Entreprise_OneController@update');
        Route::post('/', 'Module1\Info_Entreprise_OneController@store');
        Route::delete('/{id}', 'Module1\Info_Entreprise_OneController@destroy');
    });
});

// Module2 module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'module2'], function () {

  
    Route::group(['prefix' => 'stepper_driver'], function () {
        Route::get('/', 'Module2\Stepper_DriverController@index');
        Route::get('/{number}', 'Module2\Stepper_DriverController@find');
        Route::match(['post', 'put'], '/{number}', 'Module2\Stepper_DriverController@update');
        Route::post('/', 'Module2\Stepper_DriverController@store');
        Route::delete('/{number}', 'Module2\Stepper_DriverController@destroy');
    });

    Route::group(['prefix' => 'doc_identity_information'], function () {
        Route::get('/', 'Module2\Doc_Indentity_InformationController@index');
        Route::get('/{id}', 'Module2\Doc_Indentity_InformationController@find');
        Route::match(['post', 'put'], '/{id}', 'Module2\Doc_Indentity_InformationController@update');
        Route::post('/', 'Module2\Doc_Indentity_InformationController@store');
        Route::delete('/{id}', 'Module2\Doc_Indentity_InformationController@destroy');
    });
    Route::group(['prefix' => 'nationalities'], function () {
        Route::get('/', 'Module2\NationalityController@index');
        Route::get('/{id}', 'Module2\NationalityController@find');
        Route::match(['post', 'put'], '/{id}', 'Module2\NationalityController@update');
        Route::post('/', 'Module2\NationalityController@store');
        Route::delete('/{id}', 'Module2\NationalityController@destroy');
        Route::get('/search', 'Module2\NationalityController@search');
    });

    Route::group(['prefix' => 'general_informations'], function () {
        Route::get('/', 'Module2\General_InfoController@index');
        Route::get('/{id}', 'Module2\General_InfoController@find');
        Route::match(['post', 'put'], '/{id}', 'Module2\General_InfoController@update');
        Route::post('/', 'Module2\General_InfoController@store');
        Route::delete('/{id}', 'Module2\General_InfoController@destroy');
        Route::get('/search', 'Module2\General_InfoController@search');

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
        Route::get('/search', 'Module3\typeController@search');
    });

    Route::group(['prefix' => 'carosseries'], function () {
        Route::get('/', 'Module3\carosserieController@index');
        Route::get('/{id}', 'Module3\carosserieController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\carosserieController@update');
        Route::post('/', 'Module3\carosserieController@store');
        Route::delete('/{id}', 'Module3\carosserieController@destroy');
        Route::get('/search', 'Module3\carosserieController@search');

    });

    Route::group(['prefix' => 'marks'], function () {
        Route::get('/', 'Module3\markController@index');
        Route::get('/{id}', 'Module3\markController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\markController@update');
        Route::post('/', 'Module3\markController@store');
        Route::delete('/{id}', 'Module3\markController@destroy');
        Route::get('/search', 'Module3\markController@search');

    });

    Route::group(['prefix' => 'modeles'], function () {
        Route::get('/', 'Module3\modelController@index');
        Route::get('/{id}', 'Module3\modelController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\modelController@update');
        Route::post('/', 'Module3\modelController@store');
        Route::delete('/{id}', 'Module3\modelController@destroy');
        Route::get('/search', 'Module3\modelController@search');

    });


    Route::group(['prefix' => 'caractere_tech_ones'], function () {
        Route::get('/', 'Module3\caractertechoneController@index');
        Route::get('/{id}', 'Module3\caractertechoneController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\caractertechoneController@update');
        Route::post('/', 'Module3\caractertechoneController@store');
        Route::delete('/{id}', 'Module3\caractertechoneController@destroy');
        Route::get('/search', 'Module3\caractertechoneController@search');

    });


    Route::group(['prefix' => 'gear_pictures'], function () {
        Route::get('/', 'Module3\gearpictureController@index');
        Route::get('/{id}', 'Module3\gearpictureController@find');
        Route::match(['post', 'put'], '/{id}', 'Module3\gearpictureController@update');
        Route::post('/', 'Module3\gearpictureController@store');
        Route::delete('/{id}', 'Module3\gearpictureController@destroy');
        Route::get('/search', 'Module3\gearpictureController@search');

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

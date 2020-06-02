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

Route::group(['prefix' => 'parishs'], function () {
    
});
// Notification module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'notifications'], function () { 

});


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

    Route::group(['prefix' => 'catechists'], function () {
        Route::get('/','Person\CatechistController@get');
        Route::get('/{id}', 'Person\CatechistController@find');
        Route::delete('/{id}', 'Person\CatechistController@destroy');
        Route::match(['post','put'],'/{id}', 'Person\CatechistController@update');
        Route::post('/', 'Person\CatechistController@create');
    
    });

    Route::group(['prefix' => 'cathechumenes'], function () {
        Route::get('/','Person\CathechumeneController@index');
        Route::get('/{id}', 'Person\CathechumeneController@find');
        Route::get('/search', 'Person\CathechumeneController@search');
        Route::delete('/{id}', 'Person\CathechumeneController@destroy');
        Route::match(['post','put'],'/{id}', 'Person\CathechumeneController@update');
        Route::post('/', 'Person\CathechumeneController@create');
    
    });

    Route::group(['prefix' => 'contacts'], function () {
        Route::get('/','Person\ContactController@get');
        Route::get('/{id}', 'Person\ContactController@find');
        Route::get('/search', 'Person\ContactController@search');
        Route::delete('/{id}', 'Person\ContactController@destroy');
        Route::match(['post','put'],'/{id}', 'Person\ContactController@update');
        Route::post('/', 'Person\ContactController@create');
    
    });

    Route::group(['prefix' => 'professions'], function () {
        Route::get('/', 'Person\ProfessionController@index');
        Route::get('/search', 'Person\ProfessionController@search');
        Route::post('/', 'Person\ProfessionController@store');
        Route::get('/{id}', 'Person\ProfessionController@find');
        Route::match(['post', 'put'], '/{id}', 'Person\ProfessionController@update');
        Route::delete('/{id}', 'Person\ProfessionController@destroy');
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
        Route::get('/{id}', 'Person\ParishionalController@find');
        Route::delete('/{id}', 'Person\ParishionalController@find');
        Route::post('/', 'Person\ParishionalController@store');
        Route::match(['post', 'put'], '/{id}', 'Person\ParishionalController@update');
    });
});

// Place module : 'middleware' => 'auth:api',


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

    Route::group(['prefix' => 'masschedules'], function () {
        Route::get('/', 'Setting\MassSheduleController@index'); 
        Route::post('/', 'Setting\MassSheduleController@create');
        Route::get('/search', 'Setting\MassSheduleController@search');
        Route::delete('/{id}', 'Setting\MassSheduleController@destroy');
        Route::match(['post', 'put'], '/{id}', 'Setting\MassSheduleController@update');
        Route::get('/{id}', 'Setting\MassSheduleController@find');
    });   

    Route::group(['prefix' => 'parishpatrimonies'], function () {
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
        Route::get('/', 'FinanceController@getFinance');
    });
});

// Finance module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'finances'], function () {

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', 'Finance\AccountController@index');
        Route::get('/search', 'Finance\AccountController@search');
        Route::get('/{id}', 'Finance\AccountController@find');
        Route::delete('/{id}', 'Finance\AccountController@destroy');
        Route::post('/', 'Finance\AccountController@store');
        Route::match(['post', 'put'], '/{id}', 'Finance\AccountController@update');
    });

    Route::group(['prefix' => 'requests'], function () {
        Route::get('/', 'Finance\RequestForMassController@index');
        Route::get('/{id}', 'Finance\RequestForMassController@find');
        Route::get('/search', 'Finance\RequestForMassController@search');
        Route::delete('/{id}', 'Finance\RequestForMassController@destroy');
        Route::match(['post', 'put'], '/{id}', 'Finance\RequestForMassController@update');
        Route::post('/', 'Finance\RequestForMassController@store');
    });

    Route::group(['prefix' => 'natureaccounts'], function () {
        Route::get('/', 'Finance\NatureAccountController@index');
        Route::get('/search', 'Finance\NatureAccountController@search');
        Route::get('/{id}', 'Finance\NatureAccountController@find');
        Route::delete('/{id}', 'Finance\NatureAccountController@destroy');
        Route::post('/', 'Finance\NatureAccountController@store');
        Route::match(['post', 'put'], '/{id}', 'Finance\NatureAccountController@update');
    });

    Route::group(['prefix' => 'natures'], function () {
        Route::get('/', 'Finance\NatureController@index');
        Route::get('/search', 'Finance\NatureController@search');
        Route::get('/{id}', 'Finance\NatureController@find');
        Route::delete('/{id}', 'Finance\NatureController@destroy');
        Route::post('/', 'Finance\NatureController@store');
        Route::match(['post', 'put'], '/{id}', 'Finance\NatureController@update');
    });

    Route::group(['prefix' => 'tarifs'], function () {
        Route::get('/', 'Finance\TarifController@index');
        Route::get('/search', 'Finance\TarifController@search');
        Route::post('/', 'Finance\TarifController@store');
        Route::match(['post', 'put'], '/{id}', 'Finance\TarifController@update');
        Route::delete('/{id}', 'Finance\TarifController@destroy'); 
    });
});


// Catechesis module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'catechesis'], function () {
    
    Route::group(['prefix' => 'members'], function () {
        Route::get('/', 'Catechesis\MemberController@index');
        Route::post('/', 'Catechesis\MemberController@create');
        Route::get('/{id}', 'Catechesis\MemberController@find');
        Route::delete('/{id}', 'Catechesis\MemberController@destroy');
        Route::get('/search', 'Catechesis\MemberController@search');
        Route::put('/{id}', 'Catechesis\MemberController@update');
    });

    Route::group(['prefix' => 'annual-members'], function () {
        Route::get('/', 'Catechesis\AnnualMemberController@index');
        Route::get('/{id}', 'Catechesis\AnnualMemberController@find');
        Route::post('/', 'Catechesis\AnnualMemberController@create');
        Route::delete('/{id}', 'Catechesis\AnnualMemberController@destroy');
        Route::get('/', 'Catechesis\AnnualMemberController@search');
        Route::put('/{id}', 'Catechesis\AnnualMemberController@update');
    });

    Route::group(['prefix' => 'archiving'], function () {
        Route::get('/', 'Catechesis\ArchivingController@index');
        Route::get('/search', 'Catechesis\ArchivingController@search');
        Route::get('/{id}', 'Catechesis\ArchivingController@find');
        Route::delete('/{id}', 'Catechesis\ArchivingController@destroy');
        Route::post('/', 'Catechesis\ArchivingController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\ArchivingController@update');
    });

    Route::group(['prefix' => 'quarters'], function () {
        Route::get('/', 'Catechesis\QuarterController@index');
        Route::get('/search', 'Catechesis\QuarterController@search');
        Route::get('/{id}', 'Catechesis\QuarterController@find');
        Route::delete('/{id}', 'Catechesis\QuarterController@destroy');
        Route::post('/', 'Catechesis\QuarterController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\QuarterController@update');
    });

    Route::group(['prefix' => 'evaluations'], function () {
        Route::get('/', 'Catechesis\EvaluationController@index');
        Route::get('/search', 'Catechesis\EvaluationController@search');
        Route::get('/{id}', 'Catechesis\EvaluationController@find');
        Route::delete('/{id}', 'Catechesis\EvaluationController@destroy');
        Route::post('/', 'Catechesis\EvaluationController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\EvaluationController@update');
    });
});

// Sanction module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'sanctions'], function () {
    
    Route::group(['prefix' => 'sanctions'], function () {
        Route::get('/', 'Sanction\SanctionController@index');
        Route::get('/search', 'Sanction\SanctionController@search');
        Route::get('/{id}', 'Sanction\SanctionController@find');
        Route::delete('/{id}', 'Sanction\SanctionController@destroy');
        Route::post('/', 'Sanction\SanctionController@store');
        Route::match(['post', 'put'], '/{id}', 'Sanction\SanctionController@update');
    });

    Route::group(['prefix' => 'punishment-types'], function () {
        Route::get('/', 'Sanction\PunishmentTypeController@index');
        Route::get('/search', 'Sanction\PunishmentTypeController@search');
        Route::get('/{id}', 'Sanction\PunishmentTypeController@find');
        Route::get('/{id}/sanctions', 'Sanction\PunishmentTypeController@findSanctions');
        Route::delete('/{id}', 'Sanction\PunishmentTypeController@destroy');
        Route::post('/', 'Sanction\PunishmentTypeController@store');
        Route::match(['post', 'put'], '/{id}', 'Sanction\PunishmentTypeController@update');
    });

    Route::group(['prefix' => 'user-sanctions'], function () {
        Route::get('/', 'Sanction\UserSanctionController@index');
        Route::get('/search', 'Sanction\UserSanctionController@search');
        Route::get('/{id}', 'Sanction\UserSanctionController@find');
        Route::get('/{id}/users', 'Sanction\UserSanctionController@findUserSanctions');
        Route::delete('/{id}', 'Sanction\UserSanctionController@destroy');
        Route::post('/', 'Sanction\UserSanctionController@store');
        Route::match(['post', 'put'], '/{id}', 'Sanction\UserSanctionController@update');
    });

});

// Places module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'places'], function () {

    Route::group(['prefix' => 'countries'], function () {
        Route::get('/', 'Place\CityAndCountryController@countries');
        Route::get('/search-countries', 'Place\CityAndCountryController@searchCountries');
        Route::get('/search-cities', 'Place\CityAndCountryController@searchCities');
        Route::get('/{id}/cities', 'Place\CityAndCountryController@findCitiesByCountries');
        Route::get('/cities', 'Place\CityAndCountryController@cities');
    });

    Route::group(['prefix' => 'places'], function () {
        Route::get('/', 'Place\PlaceController@index');
        Route::get('/search', 'Place\PlaceController@search');
        Route::get('/{id}', 'Place\PlaceController@find');
        Route::delete('/{id}', 'Place\PlaceController@destroy');
        Route::post('/', 'Place\PlaceController@store');
        Route::match(['post', 'put'], '/{id}', 'Place\PlaceController@update');
    });

    Route::group(['prefix' => 'place-types'], function () {
        Route::get('/', 'Place\TypePlaceController@index');
        Route::get('/search', 'Place\TypePlaceController@search');
        Route::get('/{id}', 'Place\TypePlaceController@find');
        Route::get('/{id}/places', 'Place\TypePlaceController@findPlaces');
        Route::delete('/{id}', 'Place\TypePlaceController@destroy');
        Route::post('/', 'Place\TypePlaceController@store');
        Route::match(['post', 'put'], '/{id}', 'Place\TypePlaceController@update');
    });

    Route::group(['prefix' => 'postes'], function () {
        Route::get('/', 'Place\PosteController@index');
        Route::get('/search', 'Place\PosteController@search');
        Route::post('/', 'Place\PosteController@create');
        Route::match(['post', 'put'], '/{id}', 'Place\PosteController@update');
        Route::get('/{id}', 'Place\PosteController@find');
        Route::delete('/{id}', 'Place\PosteController@destroy');
    });

    Route::group(['prefix' => 'type-postes'], function () {
        Route::get('/', 'Place\TypePosteController@index');
        Route::get('/search', 'Place\TypePosteController@search');
        Route::post('/', 'Place\TypePosteController@create');
        Route::match(['post', 'put'], '/{id}', 'Place\TypePosteController@update');
        Route::get('/{id}', 'Place\TypePosteController@find');
        Route::get('/{id}/postes', 'Place\TypePosteController@findPostes');
        Route::delete('/{id}', 'Place\TypePosteController@destroy');
    });

});
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
        Route::get('permissions', 'AuthController@permissions');
        Route::get('roles', 'AuthController@roles');
        Route::get('teams', 'AuthController@teams');
    //});
});

Route::group(['prefix' => 'extras'], function () {
    Route::get('postes', 'Extra\ExtraController@getPosts');
    Route::get('groupes', 'Extra\ExtraController@getGroups');
    Route::get('cebs', 'Extra\ExtraController@getCebs');
    Route::Post('/', 'Extra\ApplyGroupController@create');

});


// Messagerie module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'messageries'], function () { });

Route::group(['prefix' => 'parishs'], function () {
    Route::get('list', 'Setting\ParishController@index');
    Route::get('/{id}/album', 'Setting\ParishController@findWithAlbum');


    
});
// Notification module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'notifications'], function () { 
    
    Route::group(['prefix' => 'parishional-messages'], function () {
        Route::get('/', 'Notification\ParishionalMessagesController@index');
        Route::get('/{id}', 'Notification\ParishionalMessagesController@find');
        Route::match(['post', 'put'], '/{id}', 'Notification\ParishionalMessagesController@update');
        Route::post('/', 'Notification\ParishionalMessagesController@create');
        Route::delete('/{id}', 'Notification\ParishionalMessagesController@destroy');
    });

    Route::group(['prefix' => 'user-parishional-messages'], function () {
        Route::get('/', 'Notification\UserParishionalMessageController@index');
        Route::get('/{id}', 'Notification\UserParishionalMessageController@find');
        Route::match(['post', 'put'], '/{id}', 'Notification\UserParishionalMessageController@update');
        Route::post('/', 'Notification\UserParishionalMessageController@create');
        Route::delete('/user/{user_id}/parishional-message/{parishional_message_id}', 'Notification\UserParishionalMessageController@destroy');
    });

});


// Person module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'persons'], function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'Person\UserController@index');
        Route::get('/search', 'Person\UserController@search');
        Route::get('/{id}', 'Person\UserController@find');
        Route::match(['post', 'put'], '/{id}', 'Person\UserController@update');
        Route::post('/reset','Person\UserController@forgotPassword');
        Route::delete('/{id}', 'Person\UserController@destroy');
    });

    Route::group(['prefix' => 'user_utypes'], function () {
        Route::get('/', 'Person\UserUtypeController@index');
        Route::get('/search', 'Person\UserUtypeController@search');
        Route::post('/', 'Person\UserUtypeController@store');
        Route::get('/{id}', 'Person\UserUtypeController@find');
        Route::get('/{id}/parishs', 'Person\UserUtypeController@findUserParishsWithStatus');
        Route::match(['post', 'put'],'/{id}/activate-parishs', 'Person\UserUtypeController@activateUserParish');
        Route::match(['post', 'put'], '/{id}', 'Person\UserUtypeController@update');
        Route::delete('/{id}', 'Person\UserUtypeController@destroy');
        Route::get('/{type}/to-chat', 'Person\UserUtypeController@findUserByType');
    });

    Route::group(['prefix' => 'user-parishs'],function (){
        Route::match(['post', 'put'],'/{id}', 'Person\MigrationParishController@migrateparish');
    });

    Route::group(['prefix' => 'catechists'], function () {
        Route::get('/','Person\CatechistController@get');
        Route::get('/{id}', 'Person\CatechistController@find');
        Route::get('/{id}', 'Person\CatechistController@Search');
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
        Route::get('/{id}/parish', 'Person\ContactController@findContactWithParish');
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
        Route::get('/{id}/parish', 'Person\PriestController@getAllPriestByParish');
        Route::match(['post', 'put'], '/{id}', 'Person\PriestController@update');
        Route::post('/', 'Person\PriestController@store');
    });

    Route::group(['prefix' => 'parishionals'], function () {
        Route::get('/', 'Person\ParishionalController@index');
        Route::get('/search', 'Person\ParishionalController@search');
        Route::get('/{id}', 'Person\ParishionalController@find');
        Route::delete('/{id}', 'Person\ParishionalController@find');
        //Route::post('/', 'Person\ParishionalController@store');
        Route::post('/', 'Person\ParishionalController@create');
        Route::delete('/{id}', 'Person\ParishionalController@destroy');
        Route::post('/', 'Person\ParishionalController@store');
        Route::match(['post', 'put'], '/{id}', 'Person\ParishionalController@update');
    });


    Route::group(['prefix' => 'users_evenements'], function () {
        Route::get('/', 'Person\user_evenementController@get');
        Route::get('/{id}', 'Person\user_evenementController@find');
        Route::get('/user/{id}', 'Person\user_evenementController@findByUserId');
        Route::post('/', 'Person\user_evenementController@create');
        Route::match(['post', 'put'], '/{id}', 'Person\user_evenementController@update');
        Route::delete('/{id}', 'Person\user_evenementController@destroy');
    });
});

// Place module : 'middleware' => 'auth:api',


// Setting module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'settings'], function () {

    Route::group(['prefix' => 'parishs'], function () {
        Route::get('/', 'Setting\ParishController@index');
        Route::get('/search', 'Setting\ParishController@search');
        Route::get('/{id}', 'Setting\ParishController@findWithAlbum');
        Route::get('/{id}/presentation', 'Setting\ParishController@parishPresentation');
        Route::get('/{id}/groupbytypes', 'Setting\ParishController@findGroupbyType');
        Route::get('/{id}/masschedules', 'Setting\ParishController@findmassSchedules');
        Route::get('/{id}/parishpatrimonies', 'Setting\ParishController@findParishPatrimonies');
        Route::get('/{id}/contact', 'Setting\ParishController@findContacts');
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

    Route::group(['prefix' => 'parish_patrimonies'], function () {
        Route::get('/', 'Setting\ParishPatrimonyController@index');
        Route::get('/search', 'Setting\ParishPatrimonyController@search');
        Route::get('/{id}', 'Setting\ParishPatrimonyController@find');
        Route::delete('/{id}', 'Setting\ParishPatrimonyController@delete');
        Route::post('/', 'Setting\ParishPatrimonyController@store');
        Route::match(['post', 'put'], '/{id}', 'Setting\ParishPatrimonyController@update');
    });

    Route::group(['prefix' => 'seminarians'], function () {
        Route::get('/', 'Setting\SeminarianController@index');
        Route::get('/search', 'Setting\SeminarianController@search');
        Route::get('/{id}', 'Setting\SeminarianController@find');
        Route::get('/parish/{id}', 'Setting\SeminarianController@parishSeminarians');
        Route::delete('/{id}', 'Setting\SeminarianController@destroy');
        Route::post('/', 'Setting\SeminarianController@store');
        Route::match(['post', 'put'], '/{id}', 'Setting\SeminarianController@update');
    });

    Route::group(['prefix' => 'albums'], function () {
        Route::get('/', 'Setting\AlbumController@index');
        Route::get('/{id}', 'Setting\AlbumController@find');
        Route::get('/{id}/albums', 'Setting\AlbumController@findPhoto');
        Route::get('/search', 'Setting\AlbumController@search');
        Route::delete('/{id}', 'Setting\AlbumController@destroy');
        Route::match(['post', 'put'], '/{id}', 'Setting\AlbumController@update');
        Route::post('/', 'Setting\AlbumController@store');
    });
    Route::group(['prefix' => 'wordofpriests'], function () {
        Route::get('/', 'Setting\WordofpriestController@index');
        Route::get('/{id}/parish', 'Setting\WordofpriestController@findWordPriest');
      
    });
    Route::group(['prefix' => 'parish_themes'], function () {
        Route::get('/', 'Setting\Parish_themeController@index');
        Route::get('/{id}/parish', 'Setting\Parish_themeController@findParishTheme');
      
    });
     
    Route::group(['prefix' => 'photos'], function () {
        Route::get('/', 'Setting\PhotoController@index');
        Route::get('/{id}', 'Setting\PhotoController@find');
        Route::get('/search', 'Setting\PhotoController@search');
        Route::delete('/{id}', 'Setting\PhotoController@destroy');
        Route::match(['post', 'put'], '/{id}', 'Setting\PhotoController@update');
        Route::post('/', 'Setting\PhotoController@store');
    });

    Route::group(['prefix' => 'user_parishs'], function () {
        Route::get('/', 'Setting\UserParishController@index');
        Route::get('/search', 'Setting\UserParishController@search');
        Route::get('/{id}', 'Setting\UserParishController@find');
        Route::get('/{id}/users', 'Setting\UserParishController@findUserParish');
        Route::delete('/{id}', 'Setting\UserParishController@destroy');
        Route::post('/', 'Setting\UserParishController@store');
        Route::match(['post', 'put'], '/{id}', 'Setting\UserParishController@update');
    });


    Route::group(['prefix' => 'parish_albums'], function () {
        Route::get('/', 'Setting\ParishAlbumController@index');
        Route::get('/search', 'Setting\ParishAlbumController@search');
        Route::get('/{id}', 'Setting\ParishAlbumController@find');
        Route::get('/{id}/parishs', 'Setting\ParishAlbumController@findParishAlbum');
        Route::delete('/{id}', 'Setting\ParishAlbumController@destroy');
        Route::post('/', 'Setting\ParishAlbumController@store');
        Route::match(['post', 'put'], '/{id}', 'Setting\ParishAlbumController@update');
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

    Route::group(['prefix' => 'patterndonations'], function () {
        Route::get('/', 'Finance\PatternDonationController@get');
        Route::get('/{id}', 'Finance\PatternDonationController@find');
        Route::delete('/{id}', 'Finance\PatternDonationController@destroy');
        Route::post('/', 'Finance\PatternDonationController@store');
        Route::match(['post', 'put'], '/{id}', 'Finance\PatternDonationController@update');
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
        Route::get('/bycategorie', 'Finance\NatureController@getByCategorie');
        Route::get('/search', 'Finance\NatureController@search');
        Route::get('/{id}', 'Finance\NatureController@find');
        Route::delete('/{id}', 'Finance\NatureController@destroy');
        Route::post('/', 'Finance\NatureController@store');
        Route::match(['post', 'put'], '/{id}', 'Finance\NatureController@update');
    });

    Route::group(['prefix' => 'inputs'], function () {
        Route::get('/', 'Finance\InputController@index');
        Route::get('/{id}/mytransactions', 'Finance\InputController@findTransactionByUser');
        Route::get('/transactionsbynatures', 'Finance\InputController@findTransactionByNature');
        Route::get('/search', 'Finance\InputController@search');
        Route::get('/{id}', 'Finance\InputController@find');
        Route::delete('/{id}', 'Finance\InputController@destroy');
        Route::post('/', 'Finance\InputController@store');
        Route::match(['post', 'put'], '/{id}', 'Finance\InputController@update');
    });

    Route::group(['prefix' => 'tarifs'], function () {
        Route::get('/', 'Finance\TarifController@index');
        Route::get('/search', 'Finance\TarifController@search');
        Route::post('/', 'Finance\TarifController@store');
        Route::match(['post', 'put'], '/{id}', 'Finance\TarifController@update');
        Route::delete('/{id}', 'Finance\TarifController@destroy'); 
    });
});
Route::group(['prefix' => 'person'], function () {


        Route::get('/', 'ParishController@index');
        Route::get('/search', 'ParishController@search');

});


// Catechesis module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'catechesis'], function () {
    
    Route::group(['prefix' => 'members'], function () {
        Route::get('/', 'Catechesis\MemberController@index');
        Route::post('/', 'Catechesis\MemberController@create');
        Route::get('/{id}', 'Catechesis\MemberController@find');
        Route::delete('/{id}', 'Catechesis\MemberController@destroy');
        Route::get('/search', 'Catechesis\MemberController@search');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\MemberController@update');
    });

    Route::group(['prefix' => 'trimestres'], function () {
        Route::get('/', 'Catechesis\TrimestreController@index');
        Route::post('/', 'Catechesis\TrimestreController@create');
        Route::get('/{id}', 'Catechesis\TrimestreController@find');
        Route::delete('/{id}', 'Catechesis\TrimestreController@destroy');
        Route::get('/search', 'Catechesis\TrimestreController@search');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\TrimestreController@update');
    });

    Route::group(['prefix' => 'quarter_trimestres'], function () {
        Route::get('/', 'Catechesis\QuarterTrimestreController@index');
        Route::post('/', 'Catechesis\QuarterTrimestreController@store');
        Route::get('/{id}', 'Catechesis\QuarterTrimestreController@find');
        Route::delete('/{id}', 'Catechesis\QuarterTrimestreController@destroy');
        Route::get('/search', 'Catechesis\QuarterTrimestreController@search');
        Route::get('/{id}/quarters', 'Catechesis\QuarterTrimestreController@findQuarterTrimestres');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\QuarterTrimestreController@update');
    });

    Route::group(['prefix' => 'transferts'], function () {
        Route::get('/', 'Catechesis\TransfertController@index');
        Route::post('/', 'Catechesis\TransfertController@create');
        Route::get('/{id}', 'Catechesis\TransfertController@find');
        Route::delete('/{id}', 'Catechesis\TransfertController@destroy');
        Route::get('/search', 'Catechesis\TransfertController@search');
        Route::put('/{id}', 'Catechesis\TransfertController@update');
    });

    Route::group(['prefix' => 'member-transferts'], function () {
        Route::get('/', 'Catechesis\MemberTransfertController@index');
        Route::get('/search', 'Catechesis\MemberTransfertController@search');
        Route::get('/{id}', 'Catechesis\MemberTransfertController@find');
        Route::get('/{id}/members', 'Catechesis\MemberTransfertController@findMemberTransferts');
        Route::delete('/{id}', 'Catechesis\MemberTransfertController@destroy');
        Route::post('/', 'Catechesis\MemberTransfertController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\MemberTransfertController@update');
    });

    Route::group(['prefix' => 'authorizations'], function () {
        Route::get('/', 'Catechesis\AuthorizationController@index');
        Route::post('/', 'Catechesis\AuthorizationController@create');
        Route::get('/{id}', 'Catechesis\AuthorizationController@find');
        Route::delete('/{id}', 'Catechesis\AuthorizationController@destroy');
        Route::get('/search', 'Catechesis\AuthorizationController@search');
        Route::match(['post', 'put'],'/{id}', 'Catechesis\AuthorizationController@update');
    });

    Route::group(['prefix' => 'annual-members'], function () {
        Route::get('/', 'Catechesis\AnnualMemberController@index');
        Route::get('/{id}', 'Catechesis\AnnualMemberController@find');
        Route::get('/{id}/classmember', 'Catechesis\AnnualMemberController@getMemberByClass');
        Route::post('/', 'Catechesis\AnnualMemberController@create');
        Route::delete('/{id}', 'Catechesis\AnnualMemberController@destroy');
        Route::get('/search', 'Catechesis\AnnualMemberController@search');
        Route::put('/{id}', 'Catechesis\AnnualMemberController@update');
    });

    Route::group(['prefix' => 'annualmember-auths'], function () {
        Route::get('/', 'Catechesis\AnnualmemberAuthorizationController@index');
        Route::get('/search', 'Catechesis\AnnualmemberAuthorizationController@search');
        Route::get('/{id}', 'Catechesis\AnnualmemberAuthorizationController@find');
        Route::get('/{id}/annual-members', 'Catechesis\AnnualmemberAuthorizationController@findAnnualmemberAuthorization');
        Route::delete('/{id}', 'Catechesis\AnnualmemberAuthorizationController@destroy');
        Route::post('/', 'Catechesis\AnnualmemberAuthorizationController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\AnnualmemberAuthorizationController@update');
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
        Route::get('/{id}/AnnuelMembers', 'Catechesis\QuarterController@findAnnuelMembers');
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

    
    Route::group(['prefix' => 'programme'], function () {
        Route::get('/','Catechesis\ProgrammeController@index');
        Route::get('/{id}', 'Catechesis\ProgrammeController@find');
        Route::delete('/{id}', 'Catechesis\ProgrammeController@destroy');
        Route::match(['post','put'],'/{id}', 'Catechesis\ProgrammeController@update');
        Route::post('/', 'Catechesis\ProgrammeController@create');
    
    });

    Route::group(['prefix' => 'patterns'], function () {
        Route::get('/', 'Catechesis\PatternController@index');
        Route::get('/search', 'Catechesis\PatternController@search');
        Route::get('/{id}', 'Catechesis\PatternController@find');
        Route::delete('/{id}', 'Catechesis\PatternController@destroy');
        Route::post('/', 'Catechesis\PatternController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\PatternController@update');
    });

    Route::group(['prefix' => 'plugs'], function () {
        Route::get('/', 'Catechesis\PlugController@index');
        Route::get('/search', 'Catechesis\PlugController@search');
        Route::get('/{id}', 'Catechesis\PlugController@find');
        Route::delete('/{id}', 'Catechesis\PlugController@destroy');
        Route::post('/', 'Catechesis\PlugController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\PlugController@update');
    });

    Route::group(['prefix' => 'catechesis'], function () {
        Route::get('/', 'Catechesis\CatechesisController@index');
        Route::get('/search', 'Catechesis\CatechesisController@search');
        Route::get('/{id}', 'Catechesis\CatechesisController@find');
        Route::delete('/{id}', 'Catechesis\CatechesisController@destroy');
        Route::post('/', 'Catechesis\CatechesisController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\CatechesisController@update');
    });

    Route::group(['prefix' => 'cathedralPesences'], function () {
        Route::get('/', 'Catechesis\CathedralPresenceController@index');
        Route::get('/search', 'Catechesis\CathedralPresenceController@search');
        Route::get('/{id}', 'Catechesis\CathedralPresenceController@find');
        Route::get('/{id}/annualmember', 'Catechesis\CathedralPresenceController@findCathedralPesences');
        Route::get('/{id}/presencemember', 'Catechesis\CathedralPresenceController@findPesencesListOfMember');
        Route::delete('/{id}', 'Catechesis\CathedralPresenceController@destroy');
        Route::post('/', 'Catechesis\CathedralPresenceController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\CathedralPresenceController@update');
    });
    Route::group(['prefix' => 'catechesisPresences'], function () {
        Route::get('/', 'Catechesis\CatechesisPresenceController@index');
        Route::get('/search', 'Catechesis\CatechesisPresenceController@search');
        Route::get('/{id}', 'Catechesis\CatechesisPresenceController@find');
        Route::get('/{id}/user_catechesis', 'Catechesis\CatechesisPresenceController@findcatechesisPresences');
        Route::get('/{id}/presence_catechesis', 'Catechesis\CatechesisPresenceController@findcatechesisOfPresences');
        Route::delete('/{id}', 'Catechesis\CatechesisPresenceController@destroy');
        Route::post('/', 'Catechesis\CatechesisPresenceController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\CatechesisPresenceController@update');
    });
    Route::group(['prefix' => 'userCatechesis'], function () {
        Route::get('/', 'Catechesis\UserCatechesisController@index');
        Route::get('/search', 'Catechesis\UserCatechesisController@search');
        Route::get('/{id}', 'Catechesis\UserCatechesisController@find');
        Route::get('/{id}/user', 'Catechesis\UserCatechesisController@findUserCatechesis');
        Route::get('/{id}/catechesis', 'Catechesis\UserCatechesisController@findNameUserCatechesis');
        Route::delete('/{id}', 'Catechesis\UserCatechesisController@destroy');
        Route::post('/', 'Catechesis\UserCatechesisController@store');
        Route::match(['post', 'put'], '/{id}', 'Catechesis\UserCatechesisController@update');
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
        Route::get('/', 'Sanction\SacramentCategorieController@index');
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


// Sacrament module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'sacrament'], function () {
    
    Route::group(['prefix' => 'sacraments'], function () {
        Route::get('/', 'Sacrament\SacramentController@index');
        Route::get('/search', 'Sacrament\SacramentController@search');
        Route::get('/{id}', 'Sacrament\SacramentController@find');
        Route::delete('/{id}', 'Sacrament\SacramentController@destroy');
        Route::post('/', 'Sacrament\SacramentController@store');
        Route::match(['post', 'put'], '/{id}', 'Sacrament\SacramentController@update');
        Route::get('/print_composition/{id}','Sacrament\SacramentController@printCompositionFile');      
        Route::get('/print_inscription/{id}','Sacrament\SacramentController@printInscriptionFile');
    });

    Route::group(['prefix' => 'sacrament_categories'], function () {
        Route::get('/', 'Sacrament\SacramentCategorieController@index');
        Route::get('/search', 'Sacrament\SacramentCategorieController@search');
        Route::get('/{id}', 'Sacrament\SacramentCategorieController@find');
        Route::get('/{id}/sacraments', 'Sacrament\SacramentCategorieController@findSacrament');
        Route::delete('/{id}', 'Sacrament\SacramentCategorieController@destroy');
        Route::post('/', 'Sacrament\SacramentCategorieController@store');
        Route::match(['post', 'put'], '/{id}', 'Sacrament\SacramentCategorieController@update');
    });

    Route::group(['prefix' => 'user_sacraments'], function () {
        Route::get('/', 'Sacrament\UserSacramentController@index');
        Route::get('/search', 'Sacrament\UserSacramentController@search');
        Route::get('/search/{user_id}', 'Sacrament\UserSacramentController@search');
        Route::get('/{id}', 'Sacrament\UserSacramentController@find');
        Route::get('/{id}/users', 'Sacrament\UserSacramentController@findUserSacrament');
        Route::delete('/{id}', 'Sacrament\UserSacramentController@destroy');
        Route::post('/', 'Sacrament\UserSacramentController@store');
        Route::match(['post', 'put'], '/{id}', 'Sacrament\UserSacramentController@update');
    });
    
});

// associations module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'associations'], function () {

    Route::group(['prefix' => 'associations'], function () {
        Route::get('/', 'Association\AssociationController@index');
        Route::get('/search', 'Association\AssociationController@search');
        Route::get('/{id}', 'Association\AssociationController@find');
        Route::get('/{id}/memberBureau', 'Association\AssociationController@findWithMemberBureau');
        Route::get('/{id}/type', 'Association\AssociationController@findTypeAssociation');
        Route::get('/{id}/parish', 'Association\AssociationController@findParishAssociation');
        Route::delete('/{id}', 'Association\AssociationController@destroy');
        Route::post('/', 'Association\AssociationController@store');
        Route::match(['post', 'put'], '/{id}', 'Association\AssociationController@update');
    });

    Route::group(['prefix' => 'types'], function () {
        Route::get('/', 'Association\TypeAssociationController@index');
        Route::get('/search', 'Association\TypeAssociationController@search');
        Route::get('/{id}', 'Association\TypeAssociationController@find');
        Route::delete('/{id}', 'Association\TypeAssociationController@destroy');
        Route::post('/', 'Association\TypeAssociationController@store');
        Route::match(['post', 'put'], '/{id}', 'Association\TypeAssociationController@update');
    });
    Route::group(['prefix' => 'evenements'], function () {
        Route::get('/', 'Association\EvenementController@index');
        Route::get('/search', 'Association\EvenementController@search');
        Route::get('/{id}', 'Association\EvenementController@find');
        Route::delete('/{id}', 'Association\EvenementController@destroy');
        Route::post('/', 'Association\EvenementController@store');
        Route::match(['post', 'put'], '/{id}', 'Association\EvenementController@update');
    });
    Route::group(['prefix' => 'member_associations'], function () {
        Route::get('/', 'Association\MemberAssociationController@index');
        Route::get('/search', 'Association\MemberAssociationController@search');
        Route::get('/{id}', 'Association\MemberAssociationController@find');
        Route::get('/{id}/users', 'Association\MemberAssociationController@findMemberAssociationUser');
        Route::get('/{id}/associations', 'Association\MemberAssociationController@findAllMemberAssociation');
        Route::get('/{id}/bureauAssociations', 'Association\MemberAssociationController@findBureauMemberAssociation');
        Route::delete('/{id}', 'Association\MemberAssociationController@destroy');
        Route::post('/', 'Association\MemberAssociationController@store');
        Route::match(['post', 'put'], '/{id}', 'Association\MemberAssociationController@update');
    });
    Route::group(['prefix' => 'statut'], function () {
        Route::get('/', 'Association\StatusController@index');
        Route::get('/search', 'Association\StatusController@search');
        Route::get('/{id}', 'Association\StatusController@find');
        Route::delete('/{id}', 'Association\StatusController@destroy');
        Route::post('/', 'Association\StatusController@store');
        Route::match(['post', 'put'], '/{id}', 'Association\StatusController@update');
    });
    Route::group(['prefix' => 'presences'], function () {
        Route::get('/', 'Association\EventPresenceMemberAssociationController@index');
        Route::get('/search', 'Association\EventPresenceMemberAssociationController@search');
        Route::get('/{id}', 'Association\EventPresenceMemberAssociationController@find');
        Route::get('/{id}/member_associations', 'Association\EventPresenceMemberAssociationController@findPresence');
        Route::delete('/{id}', 'Association\EventPresenceMemberAssociationController@destroy');
        Route::post('/', 'Association\EventPresenceMemberAssociationController@store');
        Route::match(['post', 'put'], '/{id}', 'Association\EventPresenceMemberAssociationController@update');
    });

});


Route::group(['prefix' => 'planification'],function (){
    Route::group(['prefix' => 'planings'],function (){
        Route::get('/', 'Planification\PlaningController@index');
        Route::get('/{id}', 'Planification\PlaningController@find');
        Route::get('/find/{id}', 'Planification\PlaningController@finds');
        Route::get('/{id}/{par}', 'Planification\PlaningController@findPlaningByParish');
        Route::get('/search', 'Planification\PlaningController@search');
        Route::post('/{id}', 'Planification\PlaningController@update');
        Route::post('/', 'Planification\PlaningController@create');
        Route::delete('/{id}', 'Planification\PlaningController@destroy');
        Route::get('/{parish_id}/hebdo', 'Planification\AgendaController@getAgendaByHebdo');
        Route::get('/{parish_id}/mensuelle', 'Planification\AgendaController@getAgendaByMensuelle');
        Route::get('/{parish_id}/trimestre', 'Planification\AgendaController@getAgendaByTrimestre');
    }); 

    Route::group(['prefix' => 'type_planings'],function (){
        Route::get('/', 'Planification\TypePlaningController@index');
        Route::get('/search', 'Planification\TypePlaningController@search');
        Route::get('/{id}/planings', 'Planification\TypePlaningController@findPlaning');
        Route::get('/{id}', 'Planification\TypePlaningController@find');
        Route::post('/{id}', 'Planification\TypePlaningController@update');
        Route::post('/', 'Planification\TypePlaningController@create');
        Route::delete('/{id}', 'Planification\TypePlaningController@destroy');
    });

    Route::group(['prefix' => 'priestplanings'],function (){
        Route::get('/', 'Planification\PriestPlaningController@index');
        Route::get('/search', 'Planification\PriestPlaningController@search');
        Route::get('/{id}/{data}', 'Planification\PriestPlaningController@findPriestPlaning');
        Route::get('/{data}', 'Planification\PriestPlaningController@findPriest');
        Route::get('/{id}', 'Planification\PriestPlaningController@find');
        Route::post('/{id}', 'Planification\PriestPlaningController@update');
        Route::post('/create/{id}', 'Planification\PriestPlaningController@create');
        Route::delete('/{id}', 'Planification\PriestPlaningController@destroy');
    });
    
    Route::group(['prefix' => 'times'],function (){
        Route::get('/', 'Planification\TimesController@index');
        Route::get('/search', 'Planification\TimesController@search');
        Route::get('/{id}/planings', 'Planification\TimesController@findPlaning');
        Route::get('/{id}', 'Planification\TimesController@find');
        Route::post('/{id}', 'Planification\TimesController@update');
        Route::post('/', 'Planification\TimesController@create');
        Route::delete('/{id}', 'Planification\TimesController@destroy');
    });
    Route::group(['prefix' => 'association_planings'],function (){
        Route::get('/', 'Planification\AssociationPlanningController@index');
        Route::get('/search', 'Planification\AssociationPlanningController@search');
        Route::get('/{id}/users', 'Planification\UserPlanningController@findAssociationPlaning');
        Route::get('/{id}', 'Planification\AssociationPlanningController@find');
        Route::post('/{id}', 'Planification\AssociationPlanningController@update');
        Route::post('/', 'Planification\AssociationPlanningController@create');
        Route::delete('/{id}', 'Planification\AssociationPlanningController@destroy');
    });

    Route::group(['prefix' => 'user_planings'],function (){
        Route::get('/', 'Planification\UserPlanningController@index');
        Route::get('/search', 'Planification\UserPlanningController@search');
       // Route::get('/{id}/users', 'Planification\UserPlanningController@findUserPlaning');
        Route::get('/{id}/users', 'Planification\UserPlanningController@findPriestPlaning');
        Route::get('/{id}', 'Planification\UserPlanningController@find');
        Route::post('/{id}', 'Planification\UserPlanningController@update');
        Route::post('/', 'Planification\UserPlanningController@store');
        Route::delete('/{id}', 'Planification\UserPlanningController@destroy');
    });
}); 

Route::group(['prefix' => 'messageries'],function (){
    
    Route::group(['prefix' => 'chat-groups'],function (){
        Route::get('/', 'Messagerie\ChatGroupController@index');
        Route::get('/search', 'Messagerie\ChatGroupController@search');
        Route::get('/{id}/users', 'Messagerie\ChatGroupController@findUsersGroup');
        Route::get('/{id}/messages', 'persons\Messagerie\ChatGroupController@findMessages');
        Route::get('/{id}/for-user', 'Messagerie\ChatGroupController@findGroupsForUSer');
        Route::get('/{id}', 'Messagerie\ChatGroupController@find');
        Route::post('/{id}', 'Messagerie\ChatGroupController@update');
        Route::post('/', 'Messagerie\ChatGroupController@store');
        Route::delete('/{id}', 'Messagerie\ChatGroupController@destroy');
    });

    Route::group(['prefix' => 'chat-member-groups'],function (){
        Route::get('/', 'Messagerie\ChatMemberGroupController@index');
        Route::get('/{id}', 'Messagerie\ChatMemberGroupController@find');
        Route::post('/{id}', 'Messagerie\ChatMemberGroupController@update');
        Route::post('/', 'Messagerie\ChatMemberGroupController@store');
        Route::delete('/{id}', 'Messagerie\ChatMemberGroupController@destroy');
    }); 

    Route::group(['prefix' => 'chat-discussions'],function (){
        Route::get('/', 'Messagerie\ChatDiscussionController@index');
        Route::get('/search', 'Messagerie\ChatDiscussionController@search');
        Route::get('/{id}/messages', 'Messagerie\ChatDiscussionController@findMessages');
        Route::get('/{id}/correspondants', 'Messagerie\ChatDiscussionController@findCorrespondants');
        Route::get('/{id}', 'Messagerie\ChatDiscussionController@find');
        Route::post('/{id}', 'Messagerie\ChatDiscussionController@update');
        Route::post('/', 'Messagerie\ChatDiscussionController@store');
        Route::delete('/{id}', 'Messagerie\ChatDiscussionController@destroy');
    });

    Route::group(['prefix' => 'chat-messages'],function (){
        Route::get('/', 'Messagerie\ChatMessageDuoController@index');
        Route::get('/{id}/search', 'Messagerie\ChatMessageDuoController@search');
        Route::get('/{id}', 'Messagerie\ChatMessageDuoController@find');
        Route::post('/{id}', 'Messagerie\ChatMessageDuoController@update');
        Route::post('/', 'Messagerie\ChatMessageDuoController@store');
        Route::delete('/{id}', 'Messagerie\ChatMessageDuoController@destroy');
    });
    
});

// actuality module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'actualities'], function () {

    Route::group(['prefix' => 'menus'], function () {
        Route::get('/', 'Actuality\MenuController@index');
        Route::get('/{id}', 'Actuality\MenuController@find');
        Route::match(['post', 'put'], '/{id}', 'Actuality\MenuController@update');
        Route::get('/search', 'Actuality\MenuController@search');
        Route::get('/findAttributeMenu/{id}', 'Actuality\MenuController@findAttributeMenu');
        Route::post('/', 'Actuality\MenuController@store');
        Route::delete('/{id}', 'Actuality\MenuController@destroy');
    });

    Route::group(['prefix' => 'articles'], function () {
        Route::get('/', 'Actuality\ArticleController@index');
        Route::get('/{id}', 'Actuality\ArticleController@find');
        Route::match(['post', 'put'], '/{id}', 'Actuality\ArticleController@update');
        Route::post('/', 'Actuality\ArticleController@store');
        Route::delete('/{id}', 'Actuality\ArticleController@destroy');
    });

    Route::group(['prefix' => 'attributes'], function () {
        Route::get('/', 'Actuality\AttributeController@index');
        Route::get('/{id}', 'Actuality\AttributeController@find');
        Route::match(['post', 'put'], '/{id}', 'Actuality\AttributeController@update');
        Route::post('/', 'Actuality\AttributeController@store');
        Route::delete('/{id}', 'Actuality\AttributeController@destroy');
    });

    Route::group(['prefix' => 'submenus'], function () {
        Route::get('/', 'Actuality\SubMenuController@index');
        Route::get('/{id}', 'Actuality\SubMenuController@find');
        Route::match(['post', 'put'], '/{id}', 'Actuality\SubMenuController@update');
        Route::post('/', 'Actuality\SubMenuController@store');
        Route::get('/{slug}/menu', 'Actuality\SubMenuController@findSubMenu');
	Route::get('/{id}/menus', 'Actuality\SubMenuController@findSubMenuId');
        Route::delete('/{id}', 'Actuality\SubMenuController@destroy');
    });

    Route::group(['prefix' => 'attribute_menus'], function () {
        Route::get('/', 'Actuality\Attribute_MenuController@index');
        Route::get('/{id}', 'Actuality\Attribute_MenuController@find');
        Route::match(['post', 'put'], '/{id}', 'Actuality\Attribute_MenuController@update');
        Route::post('/', 'Actuality\Attribute_MenuController@store');
        Route::delete('/{id}', 'Actuality\Attribute_MenuController@destroy');
        Route::get('/{id}/menus', 'Actuality\Attribute_MenuController@findAttributeMenu');
    });

    Route::group(['prefix' => 'article_attribute_menus'], function () {
        Route::get('/', 'Actuality\Article_Attribute_MenuController@index');
        Route::get('/{id}', 'Actuality\Article_Attribute_MenuController@find');
        Route::match(['post', 'put'], '/{id}', 'Actuality\Article_Attribute_MenuController@update');
        Route::post('/', 'Actuality\Article_Attribute_MenuController@store');
        Route::delete('/{id}', 'Actuality\Article_Attribute_MenuController@destroy');
        Route::get('/{id}/articles', 'Actuality\Article_Attribute_MenuController@findArticleMenu');
    }); 
});

Route::group(['prefix' => 'requests'],function (){
    Route::get('/{id}', 'Request\RequestController@findAllDemande');
    Route::group(['prefix' => 'make-appointments'],function (){
        Route::get('/', 'Request\MakeAppointmentController@index');
        Route::get('/{id}', 'Request\MakeAppointmentController@find');
        Route::get('/user/{id}', 'Request\MakeAppointmentController@findAllForUser');
        Route::get('/search', 'Request\MakeAppointmentController@search');
        Route::post('/{id}', 'Request\MakeAppointmentController@update');
        Route::post('/', 'Request\MakeAppointmentController@store');
        Route::get('/{id}/user', 'Request\MakeAppointmentController@findAllForUser');
        Route::delete('/{id}', 'Request\MakeAppointmentController@delete');
    });

    Route::group(['prefix' => 'object_make_appointments'],function (){
        Route::get('/', 'Request\ObjectMakeAppointmentController@index');
        Route::get('/{id}', 'Request\ObjectMakeAppointmentController@find');
        Route::get('/search', 'Request\ObjectMakeAppointmentController@search');
        Route::post('/{id}', 'Request\ObjectMakeAppointmentController@update');
        Route::post('/', 'Request\ObjectMakeAppointmentController@store');
        Route::get('/{type}/type', 'Request\ObjectMakeAppointmentController@findByType');
        Route::delete('/{id}', 'Request\ObjectMakeAppointmentController@delete');
    });

    Route::group(['prefix' => 'intention_masses'],function (){
        Route::get('/', 'Request\IntentionMassController@index');
        Route::get('/{id}', 'Request\IntentionMassController@find');
        Route::get('/search', 'Request\IntentionMassController@search');
        Route::get('/{id}/user', 'Request\IntentionMassController@findAllForUser');
        Route::post('/{id}', 'Request\IntentionMassController@update');
        Route::post('/', 'Request\IntentionMassController@store');
        Route::delete('/{id}', 'Request\IntentionMassController@destroy');
        Route::get('/masss', 'Setting\MassSheduleController@getMass');
    });

    Route::group(['prefix' => 'anointing_sicks'],function (){
        Route::get('/', 'Request\AnointingSickController@index');
        Route::get('/{id}', 'Request\AnointingSickController@find');
        Route::get('/search', 'Request\AnointingSickController@search');
        Route::get('/{id}/user', 'Request\AnointingSickController@findAllForUser');
        Route::post('/{id}', 'Request\AnointingSickController@update');
        Route::post('/', 'Request\AnointingSickController@store');
        Route::delete('/{id}', 'Request\AnointingSickController@destroy');
    });

    Route::group(['prefix' => 'report_problems'],function (){
        Route::get('/', 'Request\ReportProblemController@index');
        Route::get('/{id}/search', 'Request\ReportProblemController@search');
        Route::get('/{id}', 'Request\ReportProblemController@find');
        Route::get('/{id}/user', 'Request\ReportProblemController@findAllForUser');
        Route::post('/{id}', 'Request\ReportProblemController@update');
        Route::post('/', 'Request\ReportProblemController@store');
        Route::delete('/{id}', 'Request\ReportProblemController@destroy');
    });
    
    Route::group(['prefix' => 'setting_requests'],function (){
        Route::get('/', 'Request\SettingRequestController@index');
        Route::get('/{id}/search', 'Request\SettingRequestController@search');
        Route::get('/{id}/user', 'Request\SettingRequestController@findAllForUser');
        Route::get('/{slug}', 'Request\SettingRequestController@findBySlug');
        Route::post('/{id}', 'Request\SettingRequestController@update');
        Route::post('/', 'Request\SettingRequestController@store');
        Route::delete('/{id}', 'Request\SettingRequestController@destroy');
    });

    Route::group(['prefix' => 'request_masses'],function (){
        Route::get('/', 'Request\RequestMassController@get');
        Route::get('/{id}', 'Request\RequestMassController@find');
        Route::get('/{id}/user', 'Request\RequestMassController@findAllForUser');
        Route::get('/search', 'Request\RequestMassController@search');
        Route::post('/{id}', 'Request\RequestMassController@update');
        Route::post('/', 'Request\RequestMassController@store');
        Route::delete('/{id}', 'Request\RequestMassController@delete');
    });

    Route::group(['prefix' => 'object_request_masses'],function (){
        Route::get('/', 'Request\ObjectRequestMassController@get');
        Route::get('/{id}', 'Request\ObjectRequestMassController@find');
        Route::get('/search', 'Request\ObjectRequestMassController@search');
        Route::post('/{id}', 'Request\ObjectRequestMassController@update');
        Route::post('/', 'Request\ObjectRequestMassController@store');
        Route::delete('/{id}', 'Request\ObjectRequestMassController@delete');
    });
});

//liturgical module : 'middleware' => 'auth:api'
Route::group(['prefix' => 'liturgicals'],function(){
    Route::group(['prefix' => 'liturgical_types'], function () {
        Route::get('/', 'Liturgical\LiturgicalTypeController@index');
        Route::get('/{id}', 'Liturgical\LiturgicalTypeController@find');
        Route::match(['post', 'put'], '/{id}', 'Liturgical\LiturgicalTypeController@update');
        Route::get('/search', 'Liturgical\LiturgicalTypeController@search');
        Route::post('/', 'Liturgical\LiturgicalTypeController@store');
        Route::delete('/{id}', 'Liturgical\LiturgicalTypeController@destroy');
    });
    
    Route::group(['prefix' => 'entry_types'], function () {
        Route::get('/', 'Liturgical\EntryTypeController@index');
        Route::get('/{id}', 'Liturgical\EntryTypeController@find');
        Route::match(['post', 'put'], '/{id}', 'Liturgical\EntryTypeController@update');
        Route::get('/search', 'Liturgical\EntryTypeController@search');
        Route::post('/', 'Liturgical\EntryTypeController@store');
        Route::delete('/{id}', 'Liturgical\EntryTypeController@destroy');
    });


    Route::group(['prefix' => 'liturgical_type_entry_types'], function () {
        Route::get('/', 'Liturgical\LiturgicalTypeEntryTypeController@index');
        Route::get('/{id}', 'Liturgical\LiturgicalTypeEntryTypeController@find');
        Route::match(['post', 'put'], '/{id}', 'Liturgical\LiturgicalTypeEntryTypeController@update');
        Route::get('/search', 'Liturgical\LiturgicalTypeEntryTypeController@search');
        Route::post('/', 'Liturgical\LiturgicalTypeEntryTypeController@store');
        Route::delete('/{id}', 'Liturgical\LiturgicalTypeEntryTypeController@destroy');
    });


    Route::group(['prefix' => 'liturgical_texts'], function () {
        Route::get('/', 'Liturgical\LiturgicalTextController@index');
        Route::get('/{id}', 'Liturgical\LiturgicalTextController@find');
        Route::match(['post', 'put'], '/{id}', 'Liturgical\LiturgicalTextController@update');
        Route::get('/search', 'Liturgical\LiturgicalTextController@search');
        Route::post('/', 'Liturgical\LiturgicalTextController@store');
        Route::delete('/{id}', 'Liturgical\LiturgicalTextController@destroy');
        Route::get('/{slug}/liturgical_types', 'Liturgical\LiturgicalTextController@findLiturgicalText');
        Route::get('/{slug}/entry_types/{id}/parish', 'Liturgical\LiturgicalTextController@findLiturgicalByType');
    });

});

// Publicity module : 'middleware' => 'auth:api',
Route::group(['prefix' => 'publicities'], function () {
    Route::get('/', 'Publicity\PublicityController@index');
    Route::get('/{id}', 'Publicity\PublicityController@find');
    Route::match(['post', 'put'], '/{id}', 'Publicity\PublicityController@update');
    Route::post('/', 'Publicity\PublicityController@create');
    Route::delete('/{id}', 'Publicity\PublicityController@destroy');
});

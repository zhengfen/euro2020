<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/phase', 'FrontController@phase');

Auth::routes();

// admin panel
Route::group(
    ['middleware' => ['auth', 'admin']],
    function () {
        Route::resource('/groups', 'GroupController')->only(['index', 'store', 'update', 'destroy']);
        Route::get('/api/groups', 'GroupController@index_api');
        Route::resource('/games', 'GameController')->only(['index', 'store', 'update', 'destroy']);
        Route::get('/api/games', 'GameController@index_api');
        Route::resource('/teams', 'TeamController')->only(['index', 'store', 'update', 'destroy']);
        Route::get('/api/teams', 'TeamController@index_api');
        Route::resource('/stadiums', 'StadiumController')->only(['index', 'store', 'update', 'destroy']);
        Route::get('/api/stadiums', 'StadiumController@index_api');
    }
);


//Route::resource('/groups/groupList', 'GroupController')->only(['index']);
//Route::get('/groupList', 'GroupController@group_list');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// user
Route::group(
    ['middleware' => ['auth']],
    function () {
        Route::get('/pronostics', 'FrontController@pronostics');
        Route::post('/pronostics/update', 'PronosticController@update');
    }
);

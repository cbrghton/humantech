<?php

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
Route::post('generate/token', 'OAuth\LoginController@generateToken');

Route::get('/unauthorized', 'OAuth\LoginController@unauthorized')->name('login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('user', 'OAuth\RegisterController');

    Route::group(['prefix' => 'movies'], function () {
        Route::get('/', 'MovieController@index');

        Route::post('/', 'MovieController@store');

        Route::get('/{movie}', 'MovieController@show');

        Route::patch('/{movie}/sync/turns', 'MovieController@sync');

        Route::post('/{movie}', 'MovieController@update');

        Route::delete('/{movie}', 'MovieController@destroy');
    });

    Route::group(['prefix' => 'turns'], function () {
        Route::get('/', 'TurnController@index');

        Route::post('/', 'TurnController@store');

        Route::get('/{turn}', 'TurnController@show');

        Route::patch('/{turn}/sync/movies', 'TurnController@sync');

        Route::post('/{turn}', 'TurnController@update');

        Route::delete('/{turn}', 'TurnController@destroy');
    });
});

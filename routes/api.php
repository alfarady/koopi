<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'KoopiController@users');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'KoopiController@products');
        Route::get('/{id}', 'KoopiController@showProducts');
    });
    
    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', 'KoopiController@transactions');
        Route::get('/{id}', 'KoopiController@showTransactions');
        Route::post('/', 'KoopiController@doTransactions');
    });
});
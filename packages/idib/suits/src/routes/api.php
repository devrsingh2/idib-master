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

Route::group(['middleware' => ['api'], 'prefix' => 'api/{key}'], function() {
    Route::GET('get-suit-fabrics', 'Idib\Suits\Controllers\SuitApiController@getSuitFabrics');
    Route::GET('get-suit-accent', 'Idib\Suits\Controllers\SuitApiController@getSuitAccent');
    Route::GET('get-suit-style', 'Idib\Suits\Controllers\SuitApiController@getSuitStyle');
    Route::GET('get-suit-pant', 'Idib\Suits\Controllers\SuitApiController@getSuitPant');
    Route::GET('get-suit-vest', 'Idib\Suits\Controllers\SuitApiController@getSuitVest');
});

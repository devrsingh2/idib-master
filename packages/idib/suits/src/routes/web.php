<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//control language start here
//$locale = \Illuminate\Support\Facades\Request::segment(1);
//control language start here
Route::middleware(['auth'])->prefix('admin')->group(function () {
//dd('s');
    /*Route::get('/suits/fabrics', '\Idib\Suits\Controllers\FabricController@index')->name('admin.suits.fabrics');
    Route::get('/suits/fabrics/add', '\Idib\Suits\Controllers\FabricController@addFabric')->name('admin.suits.fabrics.add');
    Route::post('/suits/fabrics/store', '\Idib\Suits\Controllers\FabricController@storeFabric')->name('admin.suits.fabrics.store');
    Route::get('/suits/fabrics/{id}/edit', '\Idib\Suits\Controllers\FabricController@editFabric')->name('admin.suits.fabrics.edit');
    Route::post('/suits/fabrics/{id}/update', '\Idib\Suits\Controllers\FabricController@updateFabric')->name('admin.suits.fabrics.update');*/

    /*Route::get('/suits/accents', '\Idib\Suits\Controllers\AccentController@index')->name('admin.suits.accents');
    Route::get('/suits/accents/add', '\Idib\Suits\Controllers\FabricController@addFabric')->name('admin.suits.accents.add');
    Route::post('/suits/accents/store', '\Idib\Suits\Controllers\FabricController@storeFabric')->name('admin.suits.accents.store');
    Route::get('/suits/accents/{id}/edit', '\Idib\Suits\Controllers\FabricController@editFabric')->name('admin.suits.accents.edit');
    Route::post('/suits/accents/{id}/update', '\Idib\Suits\Controllers\FabricController@updateFabric')->name('admin.suits.accents.update');*/

});
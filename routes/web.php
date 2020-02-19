<?php

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

Route::get('/', 'HomeController@index')->name('home');

//Auth::routes();
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@postLogin')->name('post-login');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@postRegister')->name('submit-signup');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/products', 'ProductController@index')->name('admin.products');

    Route::get('/orders', 'OrderController@index')->name('admin.orders');

    //categories
    Route::get('/{id}/categories', 'CategoryController@index')->name('admin.categories');
    Route::get('/{id}/categories/add', 'CategoryController@addCategory')->name('admin.categories.add');

    //fabrics
    Route::get('/{id}/fabrics', 'FabricController@index')->name('admin.fabrics');
    Route::get('/{id}/fabrics/add', 'FabricController@addFabric')->name('admin.fabrics.add');


    Route::get('/profile', 'UserController@profile')->name('admin.profile');
    Route::post('/update-profile', 'UserController@updateProfile')->name('admin.profile.update');
    Route::get('/settings', 'UserController@setting')->name('admin.setting');

    Route::get('setting', 'UserController@getSetting')->name('admin.setting');
    Route::post('setting', 'UserController@getSetting')->name('admin.setting');

    Route::get('notification', 'NotificationController@userNotification')->name('admin.notification');
    Route::get('get-notification', 'NotificationController@getVendorNotificationFromCustomer')->name('admin.get-notification');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'AdminController@dashboard')->name('user.dashboard');

    Route::get('/profile', 'UserController@profile')->name('user.profile');
    Route::post('/update-profile', 'UserController@updateProfile')->name('user.profile.update');
    Route::get('/settings', 'UserController@setting')->name('user.setting');

    Route::get('setting', 'UserController@getSetting')->name('user.setting');
    Route::post('setting', 'UserController@getSetting')->name('user.setting');

    Route::get('notification', 'NotificationController@userNotification')->name('user.notification');
    Route::get('get-notification', 'NotificationController@getVendorNotificationFromCustomer')->name('user.get-notification');
});

Route::get('logout', 'HomeController@getLogout')->name('user.logout');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');
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
    Route::get('/', 'AdminController@dashboard');

    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/products', 'ProductController@index')->name('admin.products');

    Route::get('/orders', 'OrderController@index')->name('admin.orders');

    //categories
    Route::get('/{id}/categories', 'CategoryController@index')->name('admin.categories');
//    Route::get('/{id}/categories/add', 'CategoryController@addCategory')->name('admin.categories.add');
    Route::get('/{pid}/categories/edit/{id}', 'CategoryController@editCategory')->name('admin.categories.edit');
    Route::post('/{pid}/categories/update/{id}', 'CategoryController@updateCategory')->name('admin.categories.update');
    //sub-categories
    Route::get('/{pid}/categories/{id}/sub-categories', 'CategoryController@subCategories')->name('admin.categories.sub-categories');
    Route::get('/{pid}/categories/{id}/sub-categories/add', 'CategoryController@addSubCategory')->name('admin.categories.sub-categories.add');
    Route::post('/{pid}/categories/{id}/sub-categories', 'CategoryController@storeSubCategory')->name('admin.categories.sub-categories.submit');
    Route::get('/{pid}/categories/{cid}/sub-categories/{id}/edit', 'CategoryController@editSubCategory')->name('admin.categories.sub-categories.edit');
    Route::get('/{pid}/categories/{cid}/sub-categories/{id}/delete', 'CategoryController@deleteSubCategory')->name('admin.categories.sub-categories.delete');
//    Route::post('/{pid}/categories/update/{id}', 'CategoryController@updateCategory')->name('admin.categories.update');

    Route::get('/suits/fabrics', '\Idib\Suits\Controllers\FabricController@index')->name('admin.suits.fabrics');
    Route::get('/suits/fabrics/add', '\Idib\Suits\Controllers\FabricController@addFabric')->name('admin.suits.fabrics.add');
    Route::post('/suits/fabrics/store', '\Idib\Suits\Controllers\FabricController@storeFabric')->name('admin.suits.fabrics.store');
    Route::get('/suits/fabrics/{id}/edit', '\Idib\Suits\Controllers\FabricController@editFabric')->name('admin.suits.fabrics.edit');
    Route::post('/suits/fabrics/{id}/update', '\Idib\Suits\Controllers\FabricController@updateFabric')->name('admin.suits.fabrics.update');
    //accent
    Route::get('/suits/accents', '\Idib\Suits\Controllers\AccentController@index')->name('admin.suits.accents');
    Route::get('/suits/accents/add', '\Idib\Suits\Controllers\AccentController@addAccent')->name('admin.suits.accents.add');
    Route::post('/suits/accents/store', '\Idib\Suits\Controllers\AccentController@storeAccent')->name('admin.suits.accents.store');
    Route::get('/suits/accents/{id}/edit', '\Idib\Suits\Controllers\AccentController@editAccent')->name('admin.suits.accents.edit');
    Route::post('/suits/accents/{id}/update', '\Idib\Suits\Controllers\AccentController@updateAccent')->name('admin.suits.accents.update');
    //accent attr
    Route::get('/suits/accent-attributes/{id}', '\Idib\Suits\Controllers\AccentAttributeController@index')->name('admin.suits.accent-attributes');
    Route::get('/suits/accent-attributes/{id}/add', '\Idib\Suits\Controllers\AccentAttributeController@addAccent')->name('admin.suits.accent-attributes.add');
    Route::post('/suits/accent-attributes/{id}/store', '\Idib\Suits\Controllers\AccentAttributeController@storeAccent')->name('admin.suits.accent-attributes.store');
    Route::get('/suits/accent-attributes/{aid}/{id}/edit', '\Idib\Suits\Controllers\AccentAttributeController@editAccent')->name('admin.suits.accent-attributes.edit');
    Route::post('/suits/accent-attributes/{aid}/{id}/update', '\Idib\Suits\Controllers\AccentAttributeController@updateAccent')->name('admin.suits.accent-attributes.update');

    //fabrics
    /*Route::get('/{id}/fabrics', 'FabricController@index')->name('admin.fabrics');
    Route::get('/{id}/fabrics/add', 'FabricController@addFabric')->name('admin.fabrics.add');
    Route::post('/{id}/fabrics/store', 'FabricController@storeFabric')->name('admin.fabrics.store');
    Route::get('/{pId}/fabrics/{id}/edit', 'FabricController@editFabric')->name('admin.fabrics.edit');
    Route::post('/{pId}/fabrics/{id}/update', 'FabricController@updateFabric')->name('admin.fabrics.update');*/


    Route::get('/profile', 'UserController@profile')->name('admin.profile');
    Route::post('/update-profile', 'UserController@updateProfile')->name('admin.profile.update');
    Route::get('/settings', 'UserController@setting')->name('admin.setting');

    Route::get('setting', 'UserController@getSetting')->name('admin.setting');
    Route::post('setting', 'UserController@getSetting')->name('admin.setting');

//    Route::get('notification', 'NotificationController@userNotification')->name('admin.notification');
//    Route::get('get-notification', 'NotificationController@getVendorNotificationFromCustomer')->name('admin.get-notification');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'AdminController@dashboard')->name('user.dashboard');

    Route::get('/profile', 'UserController@profile')->name('user.profile');
    Route::post('/update-profile', 'UserController@updateProfile')->name('user.profile.update');
    Route::get('/settings', 'UserController@setting')->name('user.setting');

    Route::get('setting', 'UserController@getSetting')->name('user.setting');
    Route::post('setting', 'UserController@getSetting')->name('user.setting');

//    Route::get('notification', 'NotificationController@userNotification')->name('user.notification');
//    Route::get('get-notification', 'NotificationController@getVendorNotificationFromCustomer')->name('user.get-notification');
});

Route::get('logout', 'HomeController@getLogout')->name('user.logout');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');
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
    Route::get('/suits/categories', '\Idib\Suits\Controllers\CategoryController@index')->name('admin.suits.categories');
//    Route::get('/suits/categories/add', '\Idib\Suits\Controllers\CategoryController@addCategory')->name('admin.suits.categories.add');
    Route::get('/suits/categories/edit/{id}', '\Idib\Suits\Controllers\CategoryController@editCategory')->name('admin.suits.categories.edit');
    Route::post('/suits/categories/update/{id}', '\Idib\Suits\Controllers\CategoryController@updateCategory')->name('admin.suits.categories.update');
    //sub-categories
    Route::get('/suits/categories/{id}/sub-categories', '\Idib\Suits\Controllers\CategoryController@subCategories')->name('admin.suits.categories.sub-categories');
    Route::get('/suits/categories/{id}/sub-categories/add', '\Idib\Suits\Controllers\CategoryController@addSubCategory')->name('admin.suits.categories.sub-categories.add');
    Route::post('/suits/categories/{id}/sub-categories', '\Idib\Suits\Controllers\CategoryController@storeSubCategory')->name('admin.suits.categories.sub-categories.submit');
    Route::get('/suits/categories/{cid}/sub-categories/{id}/edit', '\Idib\Suits\Controllers\CategoryController@editSubCategory')->name('admin.suits.categories.sub-categories.edit');
    Route::post('/suits/categories/{cid}/sub-categories/{id}/update', '\Idib\Suits\Controllers\CategoryController@updateSubCategory')->name('admin.suits.categories.sub-categories.update');
    Route::get('/suits/categories/{cid}/sub-categories/{id}/delete', '\Idib\Suits\Controllers\CategoryController@deleteSubCategory')->name('admin.suits.categories.sub-categories.delete');

    //styles
    Route::get('/suits/jackets', '\Idib\Suits\Controllers\StyleController@listJacketStyles')->name('admin.suits.jackets');
    Route::get('/suits/jackets/add', '\Idib\Suits\Controllers\StyleController@addJacketStyle')->name('admin.suits.jackets.add');
    Route::post('/suits/jackets/store', '\Idib\Suits\Controllers\StyleController@storeJacketStyle')->name('admin.suits.jackets.store');
    Route::get('/suits/jackets/{sid}/edit/{id}', '\Idib\Suits\Controllers\StyleController@editJacketStyle')->name('admin.suits.jackets.edit');
    Route::post('/suits/jackets/{id}/update', '\Idib\Suits\Controllers\StyleController@updateJacketStyle')->name('admin.suits.jackets.update');

    Route::get('/suits/jackets/{id}/styles', '\Idib\Suits\Controllers\StyleController@listJacketStyleAttributes')->name('admin.suits.jackets.style-attributes');

    Route::get('/suits/pants', '\Idib\Suits\Controllers\StyleController@listPantStyles')->name('admin.suits.pants');
    Route::get('/suits/pants/{id}/styles', '\Idib\Suits\Controllers\StyleController@listPantStyleAttributes')->name('admin.suits.pants.style-attributes');
    Route::get('/suits/vests', '\Idib\Suits\Controllers\StyleController@listVestStyles')->name('admin.suits.vests');
    Route::get('/suits/vests/{id}/styles', '\Idib\Suits\Controllers\StyleController@listVestStyleAttributes')->name('admin.suits.vests.style-attributes');

    //fabrics
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
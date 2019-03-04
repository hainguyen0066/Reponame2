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

Route::group(['prefix' => config('voyager.user.redirect')], function () {
    Voyager::routes();
    // Your overwrites here
    Route::group(['as' => 'voyager.', 'middleware' => 'admin.user'], function () {
        Route::get('/', ['uses' => 'Admin\DashboardController@index', 'as' => 'dashboard']);
    });
});

Auth::routes();

Route::get('/thoat', [
    'uses' => 'Auth\LoginController@logout',
    'as' => 'logout'
]);

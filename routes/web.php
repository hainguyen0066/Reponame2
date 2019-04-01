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
    Route::group(['as' => 'voyager.', 'middleware' => 'admin.user'], function () {
        Route::group(['as' => 'payments.', 'prefix' => '/payments'], function () {
            Route::get('/{user}/history', [
                'uses' => 'Admin\PaymentBreadController@history',
                'as' => 'history'
            ]);
            Route::get('/{payment}/accept', [
                'uses' => 'Admin\PaymentBreadController@accept',
                'as' => 'accept',
            ]);
            Route::get('/{payment}/reject', [
                'uses' => 'Admin\PaymentBreadController@reject',
                'as' => 'reject',
            ]);
            Route::get('/report', [
                'uses' => 'Admin\PaymentBreadController@report',
                'as' => 'report',
            ]);
        });
    });
    Voyager::routes();
    // Your overwrites here
    Route::group(['as' => 'voyager.', 'middleware' => 'admin.user'], function () {
        Route::get('/', ['uses' => 'Admin\DashboardController@index', 'as' => 'dashboard']);
    });
});

Route::group(['prefix' => 'autocomplete', 'as' => 'autocomplete.'], function () {
    Route::get('/users', ['uses' => 'AutoCompleteController@getUsers', 'as' => 'users']);
});


Auth::routes();

Route::get('/thoat', [
    'uses' => 'Auth\LoginController@logout',
    'as' => 'logout'
]);

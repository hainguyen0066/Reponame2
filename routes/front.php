<?php

Route::group(['as' => 'front.'], function() {
    Route::get('/', [
        'uses' => 'LandingPageController@index',
        'as' => 'landing'
    ]);

    Route::get('/trang-chu', [
        'uses' => 'HomePageController@index',
        'as' => 'home'
    ]);

    Route::get('/lich-su-nap-the', [
        'uses' => 'HomePageController@index',
        'as' => 'payment.history'
    ]);
    Route::get('/nap-the', [
        'uses' => 'PaymentController@index',
        'as' => 'payment.index'
    ]);
    Route::post('/nap-the', [
        'uses' => 'PaymentController@submitCard',
        'as' => 'payment.submit_card'
    ]);
    Route::get('/web-launcher',[        
        'uses' => 'WebLauncherController@index',
        'as'   => 'web_laucher'
    ]);
    

//     BEGIN CONTENT ROUTES
    Route::get('/download', [
        'uses' => 'PostController@download',
        'as' => 'page.download'
    ]);
    Route::get('/tai-game', [
        'uses' => 'PostController@download',
        'as' => 'page.download'
    ]);

    Route::get('/gioi-thieu', [
        'uses' => 'HomePageController@index',
        'as' => 'server.introduce'
    ]);

    Route::get('/ho-tro-tan-thu', [
        'uses' => 'HomePageController@index',
        'as' => 'newbie.help'
    ]);

    Route::get('/tim-kiem', [
        'uses' => 'PostController@search',
        'as' => 'search'
    ]);
    ## --------------------- Secured Routes --------------------- ##
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/quan-ly-tai-khoan', [
            'uses' => 'ManageAccount@accountInfo',
            'as' => 'manage.account.info'
        ]);
        Route::get('/thong-tin-tai-khoan', [
            'uses' => 'ManageAccount@accountInfo',
            'as' => 'manage.account.info'
        ]);
        
        Route::get('/doi-mat-khau', [
            'uses' => 'ManageAccount@changePass',
            'as' => 'manage.account.pass'
        ]);
        Route::get('/doi-mat-khau-cap-2', [
            'uses' => 'ManageAccount@changePass2',
            'as' => 'manage.account.pass2'
        ]);
        Route::get('/lich-su-giao-dich', [
            'uses' => 'ManageAccount@historyCharge',
            'as' => 'manage.account.history'
        ]);
        
        Route::post('/doi-mat-khau', [
            'uses' => 'PasswordController@changePassword',
            'as' => 'password.change.submit'
        ]);
        Route::get('/choi-game/{server}/{serverName}', [
            'uses' => 'ServerController@play',
            'as' => 'server.play'
        ]);
        Route::get('/choi-game-test/{server}/{serverName}', [
            'uses' => 'ServerController@playTest',
            'as' => 'server.play_test'
        ]);

        Route::get('/choi-ngay', [
            'uses' => 'ServerController@playNow',
            'as' => 'play_now'
        ]);
        Route::get('/ccu', [
            'uses' => 'ServerController@getCCU',
            'as' => 'server.ccu'
        ]);

        Route::post('/nhan-qua', [
            'uses' => 'GiftCodeController@getWelcomeCode',
            'as'   => 'get_welcome_code',
        ]);
    });

    $staticPages = [
        'nap_the_cao' => '/nap-the/the-cao',
        'vi_momo' => '/nap-the/vi-momo',
        'chuyen_khoan' => '/nap-the/chuyen-khoan'
    ];
    foreach ($staticPages as $name => $uri) {
        Route::get($uri, [
            'uses' => 'StaticPageController@detail',
            'as' => 'static.' . $name
        ]);
    }


    Route::get('/{categorySlug}', [
        'uses' => 'PostController@list',
        'as' => 'category'
    ]);

    Route::get('/{categorySlug}/{postSlug}', [
        'uses' => 'PostController@detail',
        'as' => 'details.post'
    ]);
});


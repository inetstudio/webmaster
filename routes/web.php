<?php

Route::group(['namespace' => 'InetStudio\Webmaster\Http\Controllers\Back'], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'back/webmaster'], function () {
        Route::group(['middleware' => 'back.auth'], function () {
            Route::any('/callback', 'WebmasterController@callback')->name('back.webmaster.callback');
            Route::any('/', 'WebmasterController@getIndex')->name('back.webmaster.index');
        });
    });
});

<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back',
    ],
    function () {

    }
);

Route::group(['namespace' => 'InetStudio\Webmaster\Http\Controllers\Back'], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'back/webmaster'], function () {
        Route::group(['middleware' => 'back.auth'], function () {
            Route::any('/callback', 'WebmasterController@callback')->name('back.webmaster.callback');
            Route::any('/', 'WebmasterController@getIndex')->name('back.webmaster.index');
        });
    });
});

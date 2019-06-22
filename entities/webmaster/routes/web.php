<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back',
    ],
    function () {
        Route::any('webmaster/callback', 'WebmasterControllerContract@callback')->name('back.webmaster.callback');

        Route::get('webmaster', 'WebmasterControllerContract@config')->name('back.webmaster.config');
    }
);

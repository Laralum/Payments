<?php

Route::group([
        'middleware' => ['web', 'laralum.base', 'laralum.auth'],
        'prefix' => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Payments\Controllers',
        'as' => 'laralum::'
    ], function () {

        Route::get('/payments', 'PaymentsController@index')->name('payments.index');

        Route::post('payments/settings/update', 'PaymentsController@updateSettings')->name('payments.settings.update');
});

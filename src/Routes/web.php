<?php

Route::group([
        'middleware' => ['web', 'laralum.base', 'laralum.auth'],
        'prefix' => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Payments\Controllers',
        'as' => 'laralum::'
    ], function () {
        Route::post('payments/settings/update', 'PaymentsController@updateSettings')->name('payments.settings.update');
});

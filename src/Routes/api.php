<?php

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth', 'throttle:60,1',
            'can:access,Laralum\Payments\Models\Settings',
        ],
        'prefix' => config('laralum.settings.api_url'),
        'namespace' => 'Laralum\Payments\Controllers',
        'as' => 'laralum_api::'
    ], function () {
        Route::post('/payments/balance', 'APIController@balance')->name('payments.balance');
        Route::post('/payments/charges', 'APIController@charges')->name('payments.charges');
        Route::post('/payments/customers', 'APIController@customers')->name('payments.customers');
});

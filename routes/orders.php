<?php
if (has_plugin('Lovata.OrdersShopaholic')) {
    Route::prefix('orders')
        ->name('orders.')
        ->group(
            function () {
                Route::post('create', 'Orders@create')->name('create');
                Route::get('{id}/position', 'Orders@positions')->name('position');
                Route::any('ipn', 'Orders@ipn')->name('ipn');
            }
        );

    Route::apiResource('paymentmethods', 'PaymentMethods', ['only' => ['index', 'show']]);

    if (has_jwtauth_plugin()) {
        Route::middleware(['jwt.auth'])
            ->group(function () {
                Route::apiResource('orders', 'Orders');
                Route::apiResource(
                    'paymentmethods',
                    'PaymentMethods',
                    [
                        'only' => [
                            'store',
                            'update',
                            'destroy'
                        ]
                    ]
                );
            });
    }
}

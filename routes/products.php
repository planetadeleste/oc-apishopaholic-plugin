<?php
Route::prefix('products')
    ->name('products.')
    ->group(
        function () {
            Route::get('list', 'Products@list')->name('list');
            Route::get('{id}/offers', 'Products@offers')->name('offers');
        }
    );
Route::apiResource('products', 'Products', ['only' => ['index', 'show']]);

if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::apiResource('products', 'Products', ['only' => ['store', 'update', 'destroy']]);
            }
        );
}

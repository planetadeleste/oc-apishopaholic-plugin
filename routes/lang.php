<?php
Route::prefix('lang')
    ->name('lang.')
    ->group(
        function () {
            Route::get('langs', 'Langs@langs');
            Route::get('locale', 'Langs@locale');
            Route::get('{lang?}', 'Langs@lang');
            Route::post('tr', 'Langs@missing');
        }
    );

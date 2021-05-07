<?php
Route::prefix('lang')
    ->name('lang.')
    ->group(
        function () {
            Route::get('{lang}', 'Langs@lang');
            Route::post('tr', 'Langs@missing');
        }
    );

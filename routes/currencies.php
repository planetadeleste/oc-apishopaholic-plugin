<?php
Route::prefix('currencies')
    ->name('currencies.')
    ->group(
        function () {
            Route::get('list', 'Currencies@list')->name('list');
        }
    );
Route::apiResource('currencies', 'Currencies', ['only' => ['index', 'show']]);

if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::apiResource('currencies', 'Currencies', ['only' => ['store', 'update', 'destroy']]);
            }
        );
}

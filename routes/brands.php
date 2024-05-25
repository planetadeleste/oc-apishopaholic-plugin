<?php

Route::prefix('brands')
    ->name('brands.')
    ->group(
        function () {
            Route::get('list', 'Brands@list')->name('list');
        }
    );
Route::apiResource('brands', 'Brands', ['only' => ['index', 'show']]);

if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::prefix('brands')
                    ->name('brands.')
                    ->group(
                        function () {
                            Route::post('upload/{id}', 'Brands@attach')->name('upload');
                        }
                    );
                Route::apiResource('brands', 'Brands', ['only' => ['store', 'update', 'destroy']]);
            }
        );
}

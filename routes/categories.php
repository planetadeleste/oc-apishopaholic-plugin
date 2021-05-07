<?php
Route::prefix('categories')
    ->name('categories.')
    ->group(
        function () {
            Route::get('list', 'Categories@list')->name('list');
            Route::get('tree', 'Categories@tree')->name('tree');
        }
    );
Route::apiResource('categories', 'Categories', ['only' => ['index', 'show']]);

if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::apiResource('categories', 'Categories', ['only' => ['store', 'update', 'destroy']]);
            }
        );
}

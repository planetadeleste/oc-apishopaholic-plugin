<?php
Route::apiResource('brands', 'Brands', ['only' => ['index', 'show']]);

if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::apiResource('brands', 'Brands', ['only' => ['store', 'update', 'destroy']]);
            }
        );
}

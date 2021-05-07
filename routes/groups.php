<?php
Route::apiResource('groups', 'Groups', ['only' => ['index', 'show']]);

if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::apiResource('groups', 'Groups', ['only' => ['store', 'update', 'destroy']]);
            }
        );
}

<?php
if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::apiResource('offers', 'Offers', ['only' => ['store', 'update', 'destroy']]);
            }
        );
}

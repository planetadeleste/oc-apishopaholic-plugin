<?php
if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::apiResource('users', 'Users');
            }
        );
}

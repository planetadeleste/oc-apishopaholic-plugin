<?php
if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::prefix('profile')
                    ->name('profile.')
                    ->group(
                        function () {
                            Route::get('avatar', 'Profile@avatar')->name('avatar');
                        }
                    );

                Route::apiResource('profile', 'Profile');
            }
        );
}

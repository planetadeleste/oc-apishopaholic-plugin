<?php
if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::prefix('profile')
                    ->name('profile.')
                    ->group(
                        function () {
                            Route::post('upload/{id}', 'Profile@attach')->name('upload');
                            Route::get('avatar', 'Profile@avatar')->name('avatar');
                        }
                    );

                Route::apiResource('profile', 'Profile');
            }
        );
}

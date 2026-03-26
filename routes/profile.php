<?php

if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            static function (): void {
                Route::prefix('profile')
                    ->name('profile.')
                    ->group(
                        static function (): void {
                            Route::post('upload/{id}', 'Profile@attach')->name('upload');
                            Route::get('avatar', 'Profile@avatar')->name('avatar');
                        }
                    );

                Route::apiResource('profile', 'Profile');
            }
        );
}

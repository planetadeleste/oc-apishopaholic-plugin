<?php
if (has_jwtauth_plugin()) {
    Route::prefix('auth')
        ->name('auth.')
        ->group(
            function () {
                Route::post('check', '\PlanetaDelEste\ApiToolbox\Classes\Api\Base@check')->name('check');
                Route::get('csrf', '\PlanetaDelEste\ApiToolbox\Classes\Api\Base@csrfToken')->name('csrf_token');

                Route::post('login', 'Auth@authenticate')->name('login');
                Route::post('register', 'Auth@signup')->name('register');
                Route::post('signup', 'Auth@signup')->name('signup');

                Route::post('restore_password', 'Auth@restorePassword')->name('restore_password');
                Route::post('reset_password', 'Auth@resetPassword')->name('reset_password');
                Route::get('check_reset_code', 'Auth@checkResetCode')->name('check_reset_code');

                Route::middleware(['jwt.auth'])->group(
                    function () {
                        Route::post('refresh', 'Auth@refresh')->name('refresh');
                        Route::post('invalidate', 'Auth@invalidate')->name('invalidate');
                    }
                );
            }
        );
}

<?php
if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::prefix('profile')
                    ->name('profile.')
                    ->group(
                        function () {
                            Route::get('address', 'Profile@address')->name('address');
                            Route::post('address/add', 'Profile@addAddress')->name('address.add');
                            Route::post('address/update', 'Profile@updateAddress')->name('address.update');
                            Route::post('address/remove', 'Profile@removeAddress')->name('address.remove');
                            Route::get('avatar', 'Profile@avatar')->name('avatar');
                        }
                    );

                Route::apiResource('profile', 'Profile');
            }
        );
}

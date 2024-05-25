<?php

if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                $sController = 'Users';
                $sPrefix     = strtolower($sController);
                Route::prefix($sPrefix)
                    ->name($sPrefix . '.')
                    ->group(function () use ($sController) {
                        Route::post('upload/{id}', $sController . '@attach')->name('upload');
                        Route::get('list', $sController . '@list')->name('list');
                    });
                Route::apiResource($sPrefix, $sController);
            }
        );
}

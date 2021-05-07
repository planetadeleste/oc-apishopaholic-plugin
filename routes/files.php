<?php
Route::prefix('files')
    ->name('files.')
    ->group(
        function () {
            Route::get('resize/{disk_name}', 'Files@thumb')->name('resize');
        }
    );

if (has_jwtauth_plugin()) {
    Route::middleware(['jwt.auth'])
        ->group(
            function () {
                Route::apiResource('files', 'Files', ['only' => ['store', 'update', 'destroy']]);
            }
        );
}

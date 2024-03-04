<?php

Route::prefix('lang')
    ->name('lang.')
    ->group(
        function () {
            Route::get('langs', 'Langs@langs');
            Route::get('locale', 'Langs@locale');
            Route::get('{lang?}', 'Langs@lang');
            Route::post('tr', 'Langs@missing');

            Route::get('yaml/{locale?}/{dump?}', function (string $locale = 'es', bool $dump = false) {
                $arLangs = [];
                $obMessage =  \RainLab\Translate\Models\Message::where('locale', $locale)->first();
                if ($obMessage) {
                    $arLangs = $obMessage->data;
                    ksort($arLangs);
                }

                if ($dump) {
                    dd(json_encode($arLangs, JSON_PRETTY_PRINT));
                }

                return response()->json($arLangs, 200, [], JSON_PRETTY_PRINT);
            });
        }
    );

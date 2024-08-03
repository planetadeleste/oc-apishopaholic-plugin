<?php

use October\Rain\Support\Arr;
use RainLab\Translate\Models\Message;

Route::prefix('lang')
    ->name('lang.')
    ->group(
        static function (): void {
            Route::get('langs', 'Langs@langs');
            Route::get('locale', 'Langs@locale');
            Route::get('{lang?}', 'Langs@lang');
            Route::post('tr', 'Langs@missing');

            Route::get('yaml/{locale?}/{dump?}/{undot?}', static function (string $locale = 'es', bool $dump = false, bool $undot = false) {
                $arLangs   = [];
                $obMessage = Message::where('locale', $locale)->first();

                if ($obMessage) {
                    $arLangs = $obMessage->data;
                    ksort($arLangs);
                }

                if ($undot) {
                    $arLangs = Arr::undot($arLangs);
                }

                if ($dump) {
                    dd(json_encode($arLangs, JSON_PRETTY_PRINT));
                }

                return response()->json($arLangs, 200, [], JSON_PRETTY_PRINT);
            });
        }
    );

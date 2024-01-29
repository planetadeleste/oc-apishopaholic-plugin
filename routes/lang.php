<?php
Route::prefix('lang')
    ->name('lang.')
    ->group(
        function () {
            Route::get('langs', 'Langs@langs');
            Route::get('locale', 'Langs@locale');
            Route::get('{lang?}', 'Langs@lang');
            Route::post('tr', 'Langs@missing');

            Route::get('yaml', function () {
                $arLangs = [];
                \RainLab\Translate\Models\Message::query()
                    ->orderBy('code')
                    ->each(function (\RainLab\Translate\Models\Message $obModel) use (&$arLangs) {
                        $sMessage = array_get($obModel->message_data, 'es');
                        $arLangs[$obModel->code] = $sMessage;
                    });

                return response()->json($arLangs, 200, [], JSON_PRETTY_PRINT);
            });
        }
    );

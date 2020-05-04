<?php
Route::get('{lang}', 'PlanetaDelEste\ApiShopaholic\Controllers\Api\Langs@lang');
Route::post('tr', 'PlanetaDelEste\ApiShopaholic\Controllers\Api\Langs@missing');

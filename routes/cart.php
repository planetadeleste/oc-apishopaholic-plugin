<?php

Route::get('data', 'PlanetaDelEste\ApiShopaholic\Controllers\Api\Cart@getData');
Route::get('get/{shipping_type_id?}', 'PlanetaDelEste\ApiShopaholic\Controllers\Api\Cart@get');
Route::post('add', 'PlanetaDelEste\ApiShopaholic\Controllers\Api\Cart@add');
Route::post('update', 'PlanetaDelEste\ApiShopaholic\Controllers\Api\Cart@update');
Route::post('remove', 'PlanetaDelEste\ApiShopaholic\Controllers\Api\Cart@remove');

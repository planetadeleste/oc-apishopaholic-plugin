<?php

Route::post('check', '\PlanetaDelEste\ApiShopaholic\Controllers\Api\Base@check');
Route::post('login', '\PlanetaDelEste\ApiShopaholic\Controllers\Api\Auth@authenticate');
Route::post('refresh', '\PlanetaDelEste\ApiShopaholic\Controllers\Api\Auth@refresh');
Route::post('invalidate', '\PlanetaDelEste\ApiShopaholic\Controllers\Api\Auth@invalidate');

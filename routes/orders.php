<?php

Route::post('create', 'Orders@create')->name('create');
Route::get('{id}/position', 'Orders@positions')->name('position');

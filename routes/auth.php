<?php

Route::post('check', 'Base@check')->name('check');
Route::post('login', 'Auth@authenticate')->name('login');
Route::post('register', 'Auth@signup')->name('register');
Route::post('refresh', 'Auth@refresh')->name('refresh');
Route::post('invalidate', 'Auth@invalidate')->name('invalidate');

<?php

Route::post('check', 'Base@check')->name('check');
Route::get('csrf', 'Base@csrfToken')->name('csrf_token');
Route::post('login', 'Auth@authenticate')->name('login');
Route::post('register', 'Auth@signup')->name('register');
Route::post('refresh', 'Auth@refresh')->name('refresh');
Route::post('invalidate', 'Auth@invalidate')->name('invalidate');
Route::post('restore_password', 'Auth@restorePassword')->name('restore_password');
Route::post('reset_password', 'Auth@resetPassword')->name('reset_password');
Route::get('check_reset_code', 'Auth@checkResetCode')->name('check_reset_code');

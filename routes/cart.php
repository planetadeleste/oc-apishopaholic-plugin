<?php

Route::get('data', 'Cart@getData')->name('data');
Route::get('get/{shipping_type_id?}', 'Cart@get')->name('get');
Route::post('add', 'Cart@add')->name('add');
Route::post('update', 'Cart@update')->name('update');
Route::post('remove', 'Cart@remove')->name('remove');
Route::get('payment_method_list', 'PaymentMethodList@get')->name('payment_method_list');

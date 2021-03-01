<?php

Route::post('address/add', 'Profile@addAddress')->name('address.add');
Route::post('address/update', 'Profile@updateAddress')->name('address.update');
Route::post('address/remove', 'Profile@removeAddress')->name('address.remove');
Route::get('avatar', 'Profile@avatar')->name('avatar');

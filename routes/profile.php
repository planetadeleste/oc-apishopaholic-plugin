<?php

Route::post('address/add', 'Profile@addAddress')->name('profile.address.add');
Route::post('address/update', 'Profile@updateAddress')->name('profile.address.update');
Route::post('address/remove', 'Profile@removeAddress')->name('profile.address.remove');

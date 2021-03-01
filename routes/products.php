<?php

Route::get('list', 'Products@list')->name('list');
Route::get('{id}/offers', 'Products@offers')->name('offers');

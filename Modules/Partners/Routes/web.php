<?php

use Illuminate\Support\Facades\Route;

Route::prefix('partners')->middleware('auth')->group(function () {
    Route::get('/', 'PartnersController@index')->name('partners.index');
    Route::post('/', 'PartnersController@store')->name('partners.store');
    Route::get('/data', 'PartnersController@getData')->name('partners.data');
});

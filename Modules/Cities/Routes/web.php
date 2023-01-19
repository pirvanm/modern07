<?php

use Illuminate\Support\Facades\Route;

Route::prefix('cities')->middleware('auth')->group(function () {
    Route::get('/', 'CitiesController@index')->name('cities.index');
    Route::get('/data', 'CitiesController@data')->name('cities.data');
});

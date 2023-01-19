<?php

use Illuminate\Support\Facades\Route;


Route::prefix('openings')->middleware('auth')->group(function () {
    Route::get('/', 'OpeningsController@index')->name('openings.index');
    Route::get('/data', 'OpeningsController@getData')->name('openings.data');
});

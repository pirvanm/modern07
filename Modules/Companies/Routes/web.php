<?php

use Illuminate\Support\Facades\Route;

Route::prefix('companies')->middleware('auth')->group(function () {
    Route::get('/', 'CompaniesController@index')->name('companies.index');
    Route::get('/search', 'CompaniesController@search')->name('companies.search');
    Route::post('/', 'CompaniesController@store')->name('companies.store');
    Route::get('/data', 'CompaniesController@data')->name('companies.data');
});

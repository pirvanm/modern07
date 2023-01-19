<?php

use Illuminate\Support\Facades\Route;

Route::prefix('users')->middleware('auth')->group(function () {
    Route::get('/data', 'UsersController@data')->name('users.data');
    Route::get('/', 'UsersController@index')->name('users.index');
    Route::post('/', 'UsersController@store')->name('users.store');
    Route::patch('/{user}', 'UsersController@update')->name('users.update');
    Route::delete('/{user}', 'UsersController@destroy')->name('users.destroy');
    Route::patch('/impersonate/{user}', 'UsersController@impersonate')->name('users.impersoante');
});

Route::prefix('roles')->group(function () {
    Route::get('/data', 'RolesController@data')->name('roles.data');
    Route::get('/', 'RolesController@index')->name('roles.index');
    Route::post('/', 'RolesController@store')->name('roles.store');
    Route::patch('/{role}', 'RolesController@update')->name('roles.update');
    Route::patch('/permissions/role/{role}', 'RolesController@updatePermissions')->name('roles.permissions.update');
    Route::delete('/{role}', 'RolesController@destroy')->name('roles.destroy');
    Route::post('/clone/{role}', 'RolesController@clone')->name('roles.clone');


});

Route::prefix('permissions')->group(function () {
    Route::get('/data', 'PermissionsController@data')->name('permissions.data');
    Route::get('/', 'PermissionsController@index')->name('permissions.index');
    Route::post('/', 'PermissionsController@store')->name('permissions.store');
    Route::patch('/{permission}', 'PermissionsController@update')->name('permissions.update');
    Route::delete('/{permission}', 'PermissionsController@destroy')->name('permissions.destroy');
});

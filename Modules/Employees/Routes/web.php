<?php

use Illuminate\Support\Facades\Route;

Route::prefix('employees')->group(function () {
    Route::get('/', 'EmployeesController@index');
});

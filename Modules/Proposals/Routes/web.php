<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::prefix('proposals')->middleware('auth')->group(function () {
    Route::get('/data', 'ProposalsController@getData')->name('proposals.data');
    Route::get('/', 'ProposalsController@index')->name('proposals.index');
    Route::get('/{proposal}', 'ProposalsController@show')->name('proposals.show');
    Route::patch('/{proposal}', 'ProposalsController@update')->name('proposals.update');
    Route::post('/', 'ProposalsController@store')->name('proposals.store');
    Route::post('/validate/location', 'ProposalsController@validateLocation')->name('proposals.validate.location');
    Route::post('/validate/address', 'ProposalsController@validateAddress')->name('proposals.validate.address');
    Route::post('/validate/owner', 'ProposalsController@validateOwner')->name('proposals.validate.owner');
    Route::post('/validate/type', 'ProposalsController@validateType')->name('proposals.validate.type');
    Route::get('/data', 'ProposalsController@getData')->name('proposals.data');
    Route::delete('/{proposal}' , 'ProposalsController@destroy')->name('proposals.destroy');
    Route::patch('/map/{proposal}', 'ProposalsController@updateMap')->name('proposals.update.map');
    Route::patch('/{proposal}/update/status', 'ProposalsController@updateStatus')->name('proposals.update.status');
    Route::post('/{proposal}/process/status', 'ProposalsController@procesStatus')->name('proposals.process.status');
    Route::post('/steps/{step}', 'ProposalStepsController@validateStep')->name('proposals.steps.validate');
});

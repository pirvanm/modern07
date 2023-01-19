<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Proposals\Entities\Proposal;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/proposals', function (Request $request) {
    return $request->user();
});

// aici incarca doar adresa cu eager loading, daca adresa exista si exista in db, tabelul, chiar daca nu sunt
// date legate, exista relatia.
Route::get('/proposals/{proposal}', function (Proposal $proposal) {
    return response()->json(
        Proposal::with('address')
        ->with('owner')
        ->with('space')
        ->findOrFail($proposal->id)
    );
});

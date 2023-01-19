<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Cities\Entities\City;
use Illuminate\Support\Facades\DB;
use Modules\Cities\Entities\County;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getStreetTypes', function () {
    return new JsonResponse(DB::table('street_types')->get(), 200);
});

Route::get('/getCounties', function () {
    return new JsonResponse(County::all(), 200);
});

Route::get('/getCountyById/{id}', function ($id) {
    try {
        return new JsonResponse(County::find($id), 200);
    } catch (Exception $e) {
        return new JsonResponse([], 400);
    }
});

Route::get('/getCities', function (Request $request) {
    return new JsonResponse(City::all(), 200);
});

Route::get('/getCityById/{id}', function (int $id) {
    try {
        return new JsonResponse(City::find($id), 200);
    } catch (Exception $e) {
        return new JsonResponse([], 400);
    }
});

Route::get('/getCitiesByCountyId/{id}', function (int $id) {
    try {
        return new JsonResponse(City::where('county_id', $id)->get()->toArray(), 200);
    } catch (Exception $e) {
        return new JsonResponse([], 400);
    }
});

// just for testing, we have to move this from here
Route::get('/roles/except/user/{id?}', function (Request $request) {
    $rolesIds = [];

    try {
        if ($request->has('id')) {
            $user = User::findOrFail($request->get('id'));
            $rolesIds = $user->roles->pluck('id');
        }

        $roles = Role::whereNotIn('id', $rolesIds)->get(['id', 'name']);

        return new JsonResponse($roles, 200);
    } catch (Exception $e) {
        return new JsonResponse([], 400);
    }
});

Route::get('/user', function (Request $request) {
    $user = User::findOrFail($request->get('id'));
    return new JsonResponse($user, 200);
});

Route::get('/permissions/except/role/{id}', function (int $id) {
    try {
        $role = Role::findOrFail($id);

        $permissions = Permission::whereNotIn('id', $role->permissions->pluck('id'))->get(['id', 'name']);

        return new JsonResponse($permissions, 200);
    } catch (Exception $e) {
        return new JsonResponse([], 400);
    }
});

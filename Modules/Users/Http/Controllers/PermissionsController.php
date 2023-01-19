<?php

namespace Modules\Users\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;
use Modules\Users\Services\PermissionsService;
use Modules\Users\Http\Requests\PermissionRequest;

class PermissionsController extends Controller
{
    protected PermissionsService $permissionsService;

    public function __construct(PermissionsService $permissionsService)
    {
        $this->permissionsService = $permissionsService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return inertia('users::pages.permissions-page');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('users::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PermissionRequest $permissionRequest)
    {
        $this->permissionsService->store($permissionRequest->validated());

        return Redirect::route('permissions.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('users::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PermissionRequest $permissionRequest, Permission $permission)
    {
        $permission->update($permissionRequest->validated());

        return Redirect::route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Permission $permission)
    {
        Permission::destroy($permission->id);

        return Redirect::route('permissions.index');
    }

    public function data(Request $request)
    {
        return response()->json($this->permissionsService->getPermissions($request));
    }
}

<?php

namespace Modules\Users\Http\Controllers;

use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Users\Http\Requests\RoleRequest;
use Modules\Users\Services\RolesService;
use Illuminate\Contracts\Support\Renderable;

use Modules\Users\Http\Requests\CloneRoleRequest;

class RolesController extends Controller
{
    protected RolesService $rolesService;

    public function __construct(RolesService $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return inertia('users::pages.roles-page');
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
    public function store(RoleRequest $roleRequest)
    {
        $this->rolesService->store($roleRequest->validated());

        return Redirect::route('roles.index');
    }

    public function clone(CloneRoleRequest $cloneRoleRequest, Role $role) {
        $this->rolesService->cloneRole($cloneRoleRequest->validated(), $role);
        return Redirect::route('roles.index');
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
    public function update(RoleRequest $roleRequest, Role $role)
    {
        $role->update($roleRequest->validated());

        return Redirect::route('roles.index');
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $this->rolesService->updatePermissions($request->all(), $role);

        return Redirect::route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Role $role)
    {
        Role::destroy($role->id);

        return Redirect::route('roles.index');
    }

    public function data(Request $request)
    {
        return response()->json($this->rolesService->getRoles($request));
    }
}

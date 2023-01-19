<?php

namespace Modules\Users\Services;

use Illuminate\Http\Request;
use App\Models\Role;

class RolesService
{
    public function store(array $data)
    {
        Role::create($data);
    }

    public function updatePermissions(array $data, Role $role)
    {
        $role->syncPermissions($data['permissions']);
    }

    public function cloneRole(array $data, Role $role)
    {
        $clonedRole = Role::create($data);
        $clonedRole->syncPermissions($role->getAllPermissions()->pluck('id'));
    }

    public function getRoles(Request $request)
    {
        $body = json_decode($request->body, true);

        $filterColumns = array_key_exists('filter', $body) ? $body['filter']['filters'] : [];
        $sort = array_key_exists('sort', $body) ? $body['sort'] : [];

        $roles = Role::query()->with('permissions')->filters($filterColumns)->sort($sort);

        // paginate and take data
        $roles = $roles->skip($body['skip'])->take($body['take'])->get();

        // we can easily use a resource here but not really
        $data = [
            'data' => $roles,
            'total' => Role::count(),
        ];

        return $data;
    }
}

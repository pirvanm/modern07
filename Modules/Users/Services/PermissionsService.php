<?php

namespace Modules\Users\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Permission;
use Modules\Users\Http\Requests\PermissionRequest;

class PermissionsService
{
    public function store(array $data)
    {
        Permission::create($data);
    }

    public function getPermissions(Request $request): array
    {
        $body = json_decode($request->body, true);

        $filterColumns = array_key_exists('filter', $body) ? $body['filter']['filters'] :[];
        $sort = array_key_exists('sort', $body) ? $body['sort'] : [];

        $permissions = Permission::query()->filters($filterColumns)->sort($sort);

        // need to deal with filters, next thing to do
        $permissions = $permissions->skip($body['skip'])->take($body['take'])->get()->toArray();

        // think of better approach
        $data = [
            'data' => $permissions,
            'total' => Permission::count(),
        ];

        return $data;
    }
}

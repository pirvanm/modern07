<?php

namespace Modules\Users\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;


class UsersService
{
    public function store(array $data)
    {
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->assignRole(Role::find($data['role_id']));
    }

    public function update(User $user, array $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        $user->roles()->sync([$data['role_id']]);
    }

    public function getUsers(Request $request)
    {

        $body = json_decode($request->body, true);

        $filterCollumns = array_key_exists('filter', $body) ? $body['filter']['filters'] :[];
        $sort = array_key_exists('sort',$body) ? $body['sort'] : [];

        $users = User::select([
            'users.id',
            'users.name',
            'users.email',
            'users.created_at',
            'roles.display_name as roles_display_name',
            'roles.id as roles'
        ])
        ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
            ->leftJoin('roles','roles.id', '=','model_has_roles.role_id')
            ->filters($filterCollumns)
            ->sort($sort);

        // need to deal with filters, next thing to do
        $users = $users->skip($body['skip'])->take($body['take'])->get();


        return $users;
    }
}

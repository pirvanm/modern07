<?php

namespace Modules\Users\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Users\Services\UsersService;
use Illuminate\Contracts\Support\Renderable;
use Modules\Users\Http\Requests\UserRequest;
use Modules\Users\Transformers\UserResource;
use Modules\Users\Http\Requests\UserUpdateRequest;

class UsersController extends Controller
{
    protected UsersService $usersService;

    // use an interface to type hint
    public function __construct(UsersService $userService)
    {
        $this->usersService = $userService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return inertia(
            'users::pages.home-page',
            ['remoteServerUrl' => 'users.data']
        );
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
    public function store(UserRequest $userRequest)
    {
        $this->usersService->store($userRequest->validated());

        return Redirect::route('users.index');
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
    public function update(UserUpdateRequest $userUpdateRequest, User $user)
    {
        $this->usersService->update($user, $userUpdateRequest->validated());

        return Redirect::route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return Redirect::route('users.index');
    }

    public function impersonate(User $user)
    {
        Auth::loginUsingId($user->id);

        return Redirect::back();
    }

    public function data(Request $request)
    {
        return UserResource::collection($this->usersService->getUsers($request))->additional(['total' => User::count()]);
    }
}
